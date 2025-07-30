<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\ShopBalance;
use App\Models\ShopBalanceLog;
use App\Models\ShopBank;
use Carbon\Carbon;

class WalletSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first shop (assuming there's at least one shop in the system)
        $shop = Shop::first();
        
        if (!$shop) {
            $this->command->info('No shops found. Please create a shop first.');
            return;
        }

        $this->command->info("Creating sample wallet data for shop: {$shop->name}");

        // Create or update shop balance
        $balance = ShopBalance::updateOrCreate(
            ['shop_id' => $shop->id],
            [
                'balance' => 2580000.00,        // Available balance: Rp 2,580,000
                'pending_in' => 750000.00,      // Pending incoming: Rp 750,000
                'pending_out' => 0.00,          // Pending outgoing: Rp 0
            ]
        );

        $this->command->info("Shop balance created/updated: Available Rp 2,580,000, Pending Rp 750,000");

        // Get existing bank accounts or use the first available ones
        $bankAccounts = ShopBank::where('shop_id', $shop->id)->get();
        
        if ($bankAccounts->isEmpty()) {
            $this->command->info('No bank accounts found for this shop. Creating sample bank accounts.');
            
            $bcaBank = ShopBank::create([
                'shop_id' => $shop->id,
                'bank_code' => 'BCA',
                'bank_name' => 'Bank Central Asia',
                'account_number' => '1234567890125678',
                'is_default' => true,
            ]);

            $mandiriBank = ShopBank::create([
                'shop_id' => $shop->id,
                'bank_code' => 'MANDIRI',
                'bank_name' => 'Bank Mandiri',
                'account_number' => '9876543210129876',
                'is_default' => false,
            ]);
        } else {
            $this->command->info('Using existing bank accounts for this shop.');
            $bcaBank = $bankAccounts->first();
            $mandiriBank = $bankAccounts->count() > 1 ? $bankAccounts->get(1) : $bcaBank;
        }

        // Create sample transaction logs
        $transactions = [
            // Recent Income (Completed)
            [
                'shop_id' => $shop->id,
                'type' => 'in',
                'amount' => 250000.00,
                'details' => [
                    'type' => 'order_settlement',
                    'orders_count' => 3,
                    'settlement_batch' => 'BATCH-2025-001',
                ],
                'shop_bank_id' => null,
                'reference' => 'ORD-2025-001',
                'status' => 'completed',
                'processed_at' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            
            // Pending Income (Today)
            [
                'shop_id' => $shop->id,
                'type' => 'in',
                'amount' => 750000.00,
                'details' => [
                    'type' => 'order_settlement',
                    'orders_count' => 5,
                    'settlement_batch' => 'BATCH-2025-002',
                    'settlement_date' => Carbon::tomorrow()->format('Y-m-d'),
                ],
                'shop_bank_id' => null,
                'reference' => 'ORD-2025-002',
                'status' => 'pending',
                'processed_at' => null,
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],

            // Successful Withdrawal (Yesterday)
            [
                'shop_id' => $shop->id,
                'type' => 'out',
                'amount' => 500000.00,
                'details' => [
                    'type' => 'withdrawal',
                    'note' => 'Manual withdrawal',
                    'bank_name' => 'Bank Central Asia',
                    'bank_code' => 'BCA',
                    'account_number' => '1234567890125678',
                ],
                'shop_bank_id' => $bcaBank->id,
                'reference' => 'WD-2025-001',
                'status' => 'completed',
                'processed_at' => Carbon::yesterday()->addHours(10),
                'created_at' => Carbon::yesterday()->subHours(2),
                'updated_at' => Carbon::yesterday()->addHours(10),
            ],

            // Older Income (3 days ago)
            [
                'shop_id' => $shop->id,
                'type' => 'in',
                'amount' => 1200000.00,
                'details' => [
                    'type' => 'order_settlement',
                    'orders_count' => 8,
                    'settlement_batch' => 'BATCH-2025-003',
                ],
                'shop_bank_id' => null,
                'reference' => 'ORD-2025-003',
                'status' => 'completed',
                'processed_at' => Carbon::now()->subDays(3)->addHours(12),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3)->addHours(12),
            ],

            // Successful Withdrawal to Mandiri (5 days ago)
            [
                'shop_id' => $shop->id,
                'type' => 'out',
                'amount' => 800000.00,
                'details' => [
                    'type' => 'withdrawal',
                    'note' => 'Weekly withdrawal',
                    'bank_name' => 'Bank Mandiri',
                    'bank_code' => 'MANDIRI',
                    'account_number' => '9876543210129876',
                ],
                'shop_bank_id' => $mandiriBank->id,
                'reference' => 'WD-2025-002',
                'status' => 'completed',
                'processed_at' => Carbon::now()->subDays(5)->addHours(14),
                'created_at' => Carbon::now()->subDays(5)->subHours(1),
                'updated_at' => Carbon::now()->subDays(5)->addHours(14),
            ],

            // Failed Withdrawal (6 days ago)
            [
                'shop_id' => $shop->id,
                'type' => 'out',
                'amount' => 300000.00,
                'details' => [
                    'type' => 'withdrawal',
                    'note' => 'Failed attempt',
                    'bank_name' => 'Bank Central Asia',
                    'bank_code' => 'BCA',
                    'account_number' => '1234567890125678',
                    'failure_reason' => 'Bank validation error',
                ],
                'shop_bank_id' => $bcaBank->id,
                'reference' => 'WD-2025-003',
                'status' => 'failed',
                'processed_at' => Carbon::now()->subDays(6)->addHours(10),
                'created_at' => Carbon::now()->subDays(6)->subHours(2),
                'updated_at' => Carbon::now()->subDays(6)->addHours(10),
            ],

            // Older Income (1 week ago)
            [
                'shop_id' => $shop->id,
                'type' => 'in',
                'amount' => 950000.00,
                'details' => [
                    'type' => 'order_settlement',
                    'orders_count' => 6,
                    'settlement_batch' => 'BATCH-2025-004',
                ],
                'shop_bank_id' => null,
                'reference' => 'ORD-2025-004',
                'status' => 'completed',
                'processed_at' => Carbon::now()->subWeek()->addHours(11),
                'created_at' => Carbon::now()->subWeek(),
                'updated_at' => Carbon::now()->subWeek()->addHours(11),
            ],

            // Older Income (2 weeks ago)
            [
                'shop_id' => $shop->id,
                'type' => 'in',
                'amount' => 1850000.00,
                'details' => [
                    'type' => 'order_settlement',
                    'orders_count' => 12,
                    'settlement_batch' => 'BATCH-2025-005',
                ],
                'shop_bank_id' => null,
                'reference' => 'ORD-2025-005',
                'status' => 'completed',
                'processed_at' => Carbon::now()->subWeeks(2)->addHours(9),
                'created_at' => Carbon::now()->subWeeks(2),
                'updated_at' => Carbon::now()->subWeeks(2)->addHours(9),
            ],
        ];

        foreach ($transactions as $transaction) {
            ShopBalanceLog::create($transaction);
        }

        $this->command->info('Sample transaction logs created:');
        $this->command->info('- 4 Income transactions (3 completed, 1 pending)');
        $this->command->info('- 3 Withdrawal transactions (2 completed, 1 failed)');
        $this->command->info('- Total balance: Rp 2,580,000 (available) + Rp 750,000 (pending)');
        
        $this->command->info('Sample data created successfully!');
    }
}
