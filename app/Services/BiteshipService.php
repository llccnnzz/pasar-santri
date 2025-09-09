<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BiteshipService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.biteship.base_url');
        $this->apiKey  = config('services.biteship.key');
    }

    protected function client()
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ]);
    }

    public function couriers()
    {
        $response = $this->client()->get($this->baseUrl . '/couriers');
        return $response->json();
    }

    public function getRates(
        string $originPostal,
        string $destinationPostal,
        array $items,
        array | string $couriers = [],
        string $weightUnit = 'g' // 'g' atau 'kg'
    ): array {
        // Normalisasi couriers (bisa string "jne,pos,tiki" atau array)
        if (is_string($couriers)) {
            $couriers = array_filter(array_map('trim', explode(',', $couriers)));
        }
        $couriers = array_values(array_unique($couriers));

        // Normalisasi items → value & weight per unit (Biteship minta GRAM)
        $normalizedItems = array_map(function ($it) use ($weightUnit) {
            $unitWeight = $it['weight'] ?? 0; // dari controller nanti diisi per unit
            $weightGram = $weightUnit === 'kg' ? (float) $unitWeight * 1000 : (float) $unitWeight;

            return [
                'name'        => $it['name'] ?? 'Item',
                'description' => $it['description'] ?? ($it['name'] ?? 'Item'),
                // VALUE per unit (IDR). Jangan pakai total (qty x price)
                'value'       => (int) round($it['value'] ?? $it['price'] ?? 0),
                // WEIGHT per unit (GRAM)
                'weight'      => (int) round($weightGram),
                'quantity'    => (int) ($it['quantity'] ?? 1),
            ];
        }, $items);

        $payload = [
            'origin_postal_code'      => (string) $originPostal,
            'destination_postal_code' => (string) $destinationPostal,
            'items'                   => $normalizedItems,
        ];
        if (! empty($couriers)) {
            $payload['couriers'] = implode(',', $couriers);
        }

        $response = Http::withToken($this->apiKey)
            ->timeout(20)
            ->retry(2, 200)
            ->post($this->baseUrl . '/rates/couriers', $payload);

        if (! $response->successful()) {
            Log::warning('Biteship rates error', [
                'status'  => $response->status(),
                'body'    => $response->json(),
                'payload' => $payload,
            ]);
            // konsisten return array kosong kalau gagal
            return [];
        }

        // Biteship mengembalikan list rate di key 'pricing'
        return $response->json('pricing', []);
    }

    public function createOrder(array $payload): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(20)
            ->retry(2, 200) // retry 2x kalau gagal
            ->post($this->baseUrl . '/orders', $payload);

        if (! $response->successful()) {
            Log::error('Biteship create order error', [
                'status'  => $response->status(),
                'body'    => $response->json(),
                'payload' => $payload,
            ]);
            return null;
        }

        return $response->json();
    }

    public function trackOrder(string $waybillId, string $trackingId): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(20)
            ->retry(2, 200)
            ->get($this->baseUrl . '/trackings/' . $trackingId
        );

        if (! $response->successful()) {
            Log::error('Biteship track order error', [
                'status'     => $response->status(),
                'body'       => $response->json(),
                'waybill_id' => $waybillId,
            ]);
            return null;
        }

        return $response->json();
    }
}
