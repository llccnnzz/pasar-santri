<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BiteshipWebhookController extends Controller
{
    public function handle(Request $request)
    {
        if (!$request->has('order_id')) {
            return response()->json(['success' => true], 200);// Acknowledge non-order webhooks gracefully
        }
        $payload = $request->all();
        Log::info("Biteship Webhook Received", $payload);

        $shipmentRefId = $payload['id'] ?? null;
        $status        = $payload['status'] ?? null;

        if (! $shipmentRefId || ! $status) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $order = Order::where('shipment_ref_id', $shipmentRefId)->first();

        if (! $order) {
            Log::warning("Order with shipment_ref_id {$shipmentRefId} not found");
            return response()->json(['message' => 'Order not found'], 404);
        }

        $newStatus = match ($status) {
            'pending', 'confirmed' => 'processing',
            'on_delivery', 'picked' => 'shipped',
            'delivered'            => 'delivered',
            default                => null,
        };

        if ($newStatus) {
            $order->update(['status' => $newStatus]);

            Log::info("Order {$order->id} updated via webhook to {$newStatus}");
        }

        return response()->json(['message' => 'Webhook processed']);
    }
}
