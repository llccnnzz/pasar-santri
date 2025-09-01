<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

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

    public function rates(array $payload)
    {
        $response = $this->client()->post($this->baseUrl . '/rates/couriers', $payload);
        return $response->json();
    }
}
