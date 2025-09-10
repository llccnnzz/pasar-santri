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

        if ($payload['event']) {
            if ($payload['event'] === 'order.status') {
                return $this->handleEventStatus($payload);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Unhandled event type: ' . $payload['event'],
                ]);
            }
        }
    }

    private function handleEventStatus($payload)
    {
        $shipmentRefId = $payload['order_id'];
        $status = $payload['status'];
        $responseMessage = '[Update Status] Order not found';

        $order = Order::where('shipment_ref_id', $shipmentRefId)->first();

        if (!$order) {
            return response()->json([
                'success' => true,
                'message' => '[Update Status] Order not found',
            ]);
        }

        if($status === 'dropping_off') {
            $order['status'] = 'shipped';
            $order->save();
            return response()->json([
                'success' => true,
                'message' => '[Update Status] Order with ID ' . $order->id . ' is now shipped',
            ]);
        }

        if($status === 'delivered') {
            $order['status'] = 'delivered';
            $order->save();
            return response()->json([
                'success' => true,
                'message' => '[Update Status] Order with ID ' . $order->id . ' is now delivered',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => '[Update Status] No action taken for status: ' . $status,
        ]);
    }
}
