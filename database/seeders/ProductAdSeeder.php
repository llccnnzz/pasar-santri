<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductAd;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;

class ProductAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Starting ProductAd seeding...\n";

        // Clear existing product ads
        ProductAd::truncate();

        // Get products with variants for processing
        $products = Product::with(['variants'])
            ->whereHas('variants')
            ->where('status', 'active')
            ->get();

        echo "Found {$products->count()} active products with variants\n";

        $categoryData = [
            ProductAd::CATEGORY_FLASH_SALE => [],
            ProductAd::CATEGORY_HOT_PROMO => [],
            ProductAd::CATEGORY_BIG_DISCOUNT => [],
            ProductAd::CATEGORY_NEW_PRODUCT => [],
            ProductAd::CATEGORY_LESS_THAN_10K => []
        ];

        // Process products for each category
        foreach ($products as $product) {
            $variant = $product->variants->first();
            if (!$variant) continue;

            $price = $variant->price ?? 0;
            $finalPrice = $variant->final_price ?? $price;
            $discount = $price > 0 ? (($price - $finalPrice) / $price * 100) : 0;

            // Big Discount: Products with discount more than 40%
            if ($discount > 40 && count($categoryData[ProductAd::CATEGORY_BIG_DISCOUNT]) < 15) {
                $categoryData[ProductAd::CATEGORY_BIG_DISCOUNT][] = [
                    'product' => $product,
                    'discount' => $discount
                ];
            }

            // New Product: Products created less than 7 days ago (expanded for demo)
            if ($product->created_at > now()->subDays(7) && count($categoryData[ProductAd::CATEGORY_NEW_PRODUCT]) < 15) {
                $categoryData[ProductAd::CATEGORY_NEW_PRODUCT][] = [
                    'product' => $product,
                    'age_days' => $product->created_at->diffInDays(now())
                ];
            }

            // Less Than 10K: Products with price less than Rp50,000 (adjusted for demo)
            if ($finalPrice > 0 && $finalPrice < 50000 && count($categoryData[ProductAd::CATEGORY_LESS_THAN_10K]) < 15) {
                $categoryData[ProductAd::CATEGORY_LESS_THAN_10K][] = [
                    'product' => $product,
                    'price' => $finalPrice
                ];
            }

            // Collect products for manual categories (Flash Sale and Hot Promo)
            if (count($categoryData[ProductAd::CATEGORY_FLASH_SALE]) < 15) {
                $categoryData[ProductAd::CATEGORY_FLASH_SALE][] = [
                    'product' => $product,
                    'price' => $finalPrice
                ];
            }

            if (count($categoryData[ProductAd::CATEGORY_HOT_PROMO]) < 15) {
                $categoryData[ProductAd::CATEGORY_HOT_PROMO][] = [
                    'product' => $product,
                    'price' => $finalPrice
                ];
            }
        }

        // Create Flash Sale ads (manual input with expiration dates)
        echo "Creating Flash Sale ads...\n";
        $flashSaleProducts = array_slice($categoryData[ProductAd::CATEGORY_FLASH_SALE], 0, 12);
        foreach ($flashSaleProducts as $index => $item) {
            ProductAd::create([
                'product_id' => $item['product']->id,
                'category' => ProductAd::CATEGORY_FLASH_SALE,
                'valid_until' => now()->addDays(rand(1, 14)), // Random expiration 1-14 days
                'is_active' => true,
                'submission_type' => ProductAd::SUBMISSION_TYPE_MANUAL,
                'admin_notes' => 'Flash sale promotion - expires soon!',
                'sort_order' => null
            ]);
        }

        // Create Hot Promo ads (manual input with sort order)
        echo "Creating Hot Promo ads...\n";
        $hotPromoProducts = array_slice($categoryData[ProductAd::CATEGORY_HOT_PROMO], 0, 12);
        foreach ($hotPromoProducts as $index => $item) {
            ProductAd::create([
                'product_id' => $item['product']->id,
                'category' => ProductAd::CATEGORY_HOT_PROMO,
                'sort_order' => $index + 1, // Sequential order
                'is_active' => true,
                'submission_type' => ProductAd::SUBMISSION_TYPE_MANUAL,
                'admin_notes' => 'Featured promotional product #' . ($index + 1),
                'valid_until' => null
            ]);
        }

        // Create Big Discount ads (auto-suggest)
        echo "Creating Big Discount ads...\n";
        $bigDiscountProducts = array_slice($categoryData[ProductAd::CATEGORY_BIG_DISCOUNT], 0, 12);
        foreach ($bigDiscountProducts as $index => $item) {
            ProductAd::create([
                'product_id' => $item['product']->id,
                'category' => ProductAd::CATEGORY_BIG_DISCOUNT,
                'is_active' => true,
                'submission_type' => ProductAd::SUBMISSION_TYPE_AUTO_SUGGEST,
                'admin_notes' => 'Auto-suggested: ' . round($item['discount'], 1) . '% discount',
                'sort_order' => null,
                'valid_until' => null
            ]);
        }

        // Create New Product ads (auto-suggest)
        echo "Creating New Product ads...\n";
        $newProducts = array_slice($categoryData[ProductAd::CATEGORY_NEW_PRODUCT], 0, 12);
        foreach ($newProducts as $index => $item) {
            ProductAd::create([
                'product_id' => $item['product']->id,
                'category' => ProductAd::CATEGORY_NEW_PRODUCT,
                'is_active' => true,
                'submission_type' => ProductAd::SUBMISSION_TYPE_AUTO_SUGGEST,
                'admin_notes' => 'Auto-suggested: Added ' . $item['age_days'] . ' days ago',
                'sort_order' => null,
                'valid_until' => null
            ]);
        }

        // Create Less Than 10K ads (auto-suggest)
        echo "Creating Less Than 10K ads...\n";
        $cheapProducts = array_slice($categoryData[ProductAd::CATEGORY_LESS_THAN_10K], 0, 12);
        foreach ($cheapProducts as $index => $item) {
            ProductAd::create([
                'product_id' => $item['product']->id,
                'category' => ProductAd::CATEGORY_LESS_THAN_10K,
                'is_active' => true,
                'submission_type' => ProductAd::SUBMISSION_TYPE_AUTO_SUGGEST,
                'admin_notes' => 'Auto-suggested: Affordable at Rp' . number_format($item['price'], 0, ',', '.'),
                'sort_order' => null,
                'valid_until' => null
            ]);
        }

        // Add some inactive ads for testing
        echo "Creating some inactive ads for testing...\n";
        $inactiveProducts = array_slice($products->toArray(), 60, 6);
        foreach ($inactiveProducts as $index => $product) {
            ProductAd::create([
                'product_id' => $product['id'],
                'category' => array_keys(ProductAd::CATEGORIES)[rand(0, 4)],
                'is_active' => false,
                'submission_type' => rand(0, 1) ? ProductAd::SUBMISSION_TYPE_MANUAL : ProductAd::SUBMISSION_TYPE_AUTO_SUGGEST,
                'admin_notes' => 'Inactive ad for testing purposes',
                'sort_order' => null,
                'valid_until' => null
            ]);
        }

        // Summary
        echo "\n=== ProductAd Seeding Summary ===\n";
        foreach (ProductAd::CATEGORIES as $key => $name) {
            $total = ProductAd::where('category', $key)->count();
            $active = ProductAd::where('category', $key)->where('is_active', true)->count();
            echo "{$name}: {$active}/{$total} (active/total)\n";
        }

        $totalAds = ProductAd::count();
        $totalActive = ProductAd::where('is_active', true)->count();
        echo "\nTotal Product Ads: {$totalActive}/{$totalAds} (active/total)\n";
        echo "ProductAd seeding completed successfully!\n";
    }
}
