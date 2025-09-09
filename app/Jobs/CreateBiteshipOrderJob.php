<?php
namespace App\Jobs;

use App\Models\Order;
use App\Models\Shop;
use App\Services\BiteshipService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateBiteshipOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(BiteshipService $biteship): void
    {
        $order = $this->order->fresh(['shop', 'user']);

        $shop     = $order->shop;
        $address  = $order->order_details['address'];
        $shipping = $order->order_details['shipping'];

        $payload = [
            "shipper_contact_name"      => $shop->name,
            "shipper_contact_phone"     => $shop->phone,
            "shipper_contact_email"     => $shop->user->email ?? null,
            "origin_contact_name"       => $shop->user->name,
            "origin_contact_phone"      => $shop->user->phone,
            "origin_contact_email"      => $shop->user->email,
            "origin_postal_code"        => $shop->postal_code,
            "origin_address"            => $shop->address,

            "destination_contact_name"  => $address['name'],
            "destination_contact_phone" => $address['phone'],
            "destination_contact_email" => $order->user->email ?? null,
            "destination_postal_code"   => $address['postal_code'],
            "destination_address"       => $address['address_line_1'],

            "courier"                   => $shipping['courier_code'],
            "courier_company"           => $shipping['courier_name'],
            "courier_service_code"      => $shipping['service_code'],
            "courier_type"              => $shipping['service_code'],

            "delivery_type"             => "now",

            "items"                     => collect($order->order_details['items'])->map(function ($it) {
                return [
                    "name"     => $it['name'],
                    "value"    => (int) $it['price'],
                    "quantity" => (int) $it['quantity'],
                    "weight"   => (int) $it['weight'],
                ];
            })->toArray(),
        ];
        Log::debug("Payload to Biteship", $payload);

        $result = $biteship->createOrder($payload);

        Log::debug("Biteship payload for Order {$order->id}", $payload);

        if ($result) {
            $order->update([
                'shipment_ref_id'  => $result['id'] ?? null,
                'tracking_details' => $result['courier'] ?? [],
                'biteship_order'   => $result,
            ]);
            Log::info("Biteship order created for Order {$order->id}", $result);
        } else {
            Log::error("Biteship order FAILED for Order {$order->id}", [
                'payload' => $payload,
            ]);
        }
    }

    protected function mapCourierType(string $serviceCode): string
    {
        return match ($serviceCode) {
            'instant', 'instant_car', 'instant_bike' => 'instant',
            'same_day', 'sds' => 'same_day',
            'nextday', 'next_day', 'yes' => 'next_day',
            'reg', 'regular', 'eko', 'ons', 'ez'     => 'regular',
            default => 'regular',
        };
    }
}
