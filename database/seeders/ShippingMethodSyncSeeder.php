<?php
namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ShippingMethodSyncSeeder extends Seeder
{
    public function run()
    {
        $apiKey   = env('BITESHIP_API_KEY');
        $response = Http::withToken($apiKey)
            ->get('https://api.biteship.com/v1/couriers')
            ->json();

        if (! empty($response['couriers'])) {
            foreach ($response['couriers'] as $courier) {
                ShippingMethod::updateOrCreate(
                    [
                        'courier_code' => $courier['courier_code'],
                        'service_code' => $courier['courier_service_code'],
                    ],
                    [
                        'courier_name' => $courier['courier_name'],
                        'service_name' => $courier['courier_service_name'],
                        'description'  => $courier['description'] ?? null,
                        'active'       => true,
                    ]
                );
            }
        } else {
            dump("No couriers found", $response);
        }
    }
}
