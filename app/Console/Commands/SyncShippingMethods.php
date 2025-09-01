<?php
namespace App\Console\Commands;

use App\Models\ShippingMethod;
use App\Services\BiteshipService;
use Illuminate\Console\Command;

class SyncShippingMethods extends Command
{
    protected $signature = 'biteship:sync-shipping';

    protected $description = 'Sync shipping methods (couriers & services) from Biteship API';

    public function handle(BiteshipService $biteship)
    {
        $this->info('Fetching couriers from Biteship...');

        $response = $biteship->couriers();

        if (empty($response['couriers'])) {
            $this->error('No couriers found from Biteship.');
            return 1;
        }

        $count = 0;
        foreach ($response['couriers'] as $courier) {
            ShippingMethod::updateOrCreate(
                [
                    'courier_code' => $courier['code'],
                    'service_code' => $courier['service_code'],
                ],
                [
                    'courier_name' => $courier['name'],
                    'service_name' => $courier['service_name'] ?? '',
                    'description'  => $courier['description'] ?? null,
                    'active'       => true,
                ]
            );
            $count++;
        }

        $this->info("Successfully synced {$count} shipping methods.");
        return 0;
    }
}
