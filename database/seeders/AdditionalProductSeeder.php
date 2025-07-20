<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdditionalProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing categories and shops
        $allCategoryIds = Category::pluck('id')->toArray();
        $allShopIds = Shop::pluck('id')->toArray();
        
        // Get existing attributes
        $roastAttr = Attribute::where('name', 'Roast Level')->first();
        $grindAttr = Attribute::where('name', 'Grind Size')->first();
        
        $roastLevels = ['Light', 'Medium', 'Dark'];
        $grindSizes = ['Whole Bean', 'Coarse', 'Medium', 'Fine'];

        // Extended product names for variety (180 more products)
        $additionalProductNames = [
            // Coffee varieties
            'Blue Mountain Jamaica', 'Kona Hawaii', 'Jamaican Blue Mountain', 'Hawaiian Kona', 'Mocha Java Blend',
            'French Roast Dark', 'Italian Espresso', 'Colombian Dark Roast', 'Brazilian Santos Medium',
            'Ethiopian Sidamo', 'Kenyan French Roast', 'Guatemalan Huehuetenango', 'Costa Rican Tarrazú',
            'Nicaraguan Matagalpa', 'Honduran Copán', 'Panamanian Boquete', 'El Salvador Pacamara',
            'Mexican Oaxaca', 'Peruvian Chanchamayo', 'Bolivian Yungas', 'Venezuelan Táchira',
            'Dominican Barahona', 'Puerto Rican Yauco', 'Cuban Serrano', 'Ecuadorian Vilcabamba',
            
            // Specialty blends
            'House Blend Medium', 'Breakfast Blend Light', 'Evening Roast Dark', 'Signature Blend',
            'Premium Gold Blend', 'Master Roaster Special', 'Artisan Dark Roast', 'Heritage Blend',
            'Anniversary Blend', 'Limited Edition Reserve', 'Seasonal Holiday Blend', 'Summer Light Roast',
            'Winter Warmer Blend', 'Spring Awakening', 'Autumn Harvest', 'Monsoon Malabar Special',
            
            // Single origin varieties
            'Yemeni Mocha', 'Thai Doi Chaang', 'Laotian Plateau', 'Indonesian Flores', 'Timor-Leste Hybrid',
            'Philippine Barako', 'Malaysian Liberica', 'Chinese Yunnan', 'Indian Plantation AA',
            'Sri Lankan Peaberry', 'Madagascar Bourbon', 'Cameroon Boyo', 'Uganda Bugisu',
            'Malawi Malanje', 'Zambian Northern', 'Zimbabwe Chipinge', 'South African Magoebaskloof',
            
            // Flavored and specialty
            'Vanilla Bean Infused', 'Hazelnut Cream', 'Caramel Macchiato Blend', 'Chocolate Truffle',
            'Cinnamon Spice', 'Cardamom Blend', 'Orange Zest', 'Mint Chocolate', 'Coconut Paradise',
            'Maple Syrup Delight', 'Irish Cream Blend', 'Amaretto Smooth', 'Rum Barrel Aged',
            'Whiskey Barrel Finish', 'Wine Barrel Aged', 'Honey Process Natural', 'Lavender Fields',
            
            // Decaf varieties
            'Decaf Colombian Supreme', 'Decaf French Roast', 'Decaf House Blend', 'Swiss Water Decaf',
            'Decaf Ethiopian', 'Decaf Brazilian', 'Decaf Mexican', 'Decaf Guatemalan',
            'Decaf Costa Rican', 'Decaf Kenyan', 'Decaf Italian Roast', 'Decaf Breakfast Blend',
            
            // Cold brew and iced
            'Cold Brew Concentrate', 'Iced Coffee Blend', 'Nitro Cold Brew', 'Japanese Iced Coffee',
            'Flash Chilled Blend', 'Cold Brew Reserve', 'Iced Americano Blend', 'Frozen Coffee Base',
            'Cold Extraction Special', 'Toddy Blend', 'New Orleans Style', 'Thai Iced Coffee',
            
            // Organic and sustainable
            'Organic Fair Trade', 'Rainforest Alliance', 'Bird Friendly Shade', 'Direct Trade Organic',
            'Biodynamic Certified', 'Carbon Neutral', 'Regenerative Agriculture', 'Wild Forest Coffee',
            'Shade Grown Organic', 'Fair Trade Plus', 'Organic Dark Roast', 'Certified Organic Light',
            
            // Espresso blends
            'Espresso Romano', 'Lungo Blend', 'Ristretto Special', 'Doppio Dark', 'Cortado Blend',
            'Macchiato Perfect', 'Cappuccino Supreme', 'Latte Art Blend', 'Mocha Base', 'Affogato Special',
            'Gibraltar Blend', 'Red Eye Strong', 'Black Eye Extra', 'Dead Eye Ultimate',
            
            // Regional specialties
            'Toraja Highland', 'Bali Kintamani', 'Java Estate', 'Aceh Gayo', 'Lampung Robusta',
            'Flores Bajawa', 'Papua Wamena', 'Sulawesi Kalosi', 'Sumatra Lintong', 'Mandailing Natural',
            'Sidikalang Arabica', 'Kerinci Kayu Aro', 'Bengkulu Rejang', 'Garut Highland', 'Bondowoso Estate',
            
            // Innovative processing
            'Honey Process Sweet', 'Natural Process Wild', 'Washed Clean Bright', 'Semi-Washed Unique',
            'Wet Hulled Traditional', 'Carbonic Maceration', 'Anaerobic Fermentation', 'Extended Fermentation',
            'Thermal Shock Process', 'Controlled Fermentation', 'Double Fermentation', 'Koji Fermented',
            
            // Micro-lot and estate
            'Estate Reserve', 'Micro-lot Special', 'Single Farm Origin', 'Family Estate', 'Heritage Farm',
            'Mountain Peak Estate', 'Valley Floor Special', 'Hilltop Reserve', 'Plantation Select',
            'Cooperative Special', 'Women Producer', 'Youth Project', 'Community Blend',
            
            // Seasonal and limited
            'Spring Harvest Early', 'Summer Solstice', 'Autumn Equinox', 'Winter Reserve',
            'New Year Celebration', 'Valentine Special', 'Easter Morning', 'Mother Day Blend',
            'Father Day Strong', 'Independence Roast', 'Thanksgiving Feast', 'Christmas Morning',
            
            // Competition and award
            'Cup of Excellence', 'Competition Winner', 'Gold Medal Roast', 'World Championship',
            'Barista Choice', 'Judges Selection', 'Critics Pick', 'Roaster Award',
            'Innovation Prize', 'Sustainability Award', 'Quality Excellence', 'Heritage Recognition'
        ];

        $tags = ['Arabica', 'Robusta', 'Single Origin', 'Espresso', 'Cold Brew', 'Drip Bag', 'Specialty Coffee', 'Decaf', 'Organic', 'Fair Trade', 'Dark Roast', 'Light Roast', 'Medium Roast', 'Blend', 'Natural Process', 'Honey Process', 'Washed', 'Estate', 'Limited Edition', 'Premium'];

        foreach ($additionalProductNames as $name) {
            $slug = Str::slug($name) . '-' . time() . '-' . rand(1000, 9999);
            $baseSku = strtoupper(Str::random(6));
            $price = rand(15000, 150000); // Higher price range for variety

            $variantMode = rand(0, 3);
            $hasVariant = $variantMode > 0;

            $specOptions = [
                'Origin' => collect(['Ethiopia', 'Colombia', 'Sumatra', 'Kenya', 'Brazil', 'Guatemala', 'Vietnam', 'Panama', 'Peru', 'Yemen', 'Jamaica', 'Hawaii', 'Mexico', 'Honduras', 'Nicaragua', 'Costa Rica', 'El Salvador', 'Bolivia', 'Venezuela', 'Ecuador', 'Philippines', 'Indonesia', 'India', 'China', 'Thailand', 'Malaysia', 'Sri Lanka', 'Madagascar', 'Cameroon', 'Uganda', 'Malawi', 'Zimbabwe', 'South Africa'])->random(),
                'Tasting Notes' => collect(['Floral', 'Citrus', 'Chocolate', 'Nutty', 'Fruity', 'Spicy', 'Earthy', 'Caramel', 'Vanilla', 'Berry', 'Wine-like', 'Herbal', 'Smoky', 'Sweet', 'Bright', 'Complex', 'Balanced', 'Rich', 'Smooth', 'Bold'])->random(rand(2,4))->implode(', '),
                'Processing Method' => collect(['Washed', 'Natural', 'Honey', 'Wet-Hulled', 'Semi-Washed', 'Carbonic Maceration', 'Anaerobic Fermentation'])->random(),
                'Altitude' => rand(800, 2500) . ' masl',
                'Body' => collect(['Light', 'Medium', 'Medium-Full', 'Full', 'Heavy'])->random(),
                'Acidity' => collect(['Low', 'Medium-Low', 'Medium', 'Medium-High', 'High', 'Bright', 'Crisp'])->random(),
                'Caffeine Level' => collect(['Regular', 'High', 'Low', 'Decaf'])->random(),
                'Packaging' => collect(['100g Bag', '250g Bag', '500g Bag', '1kg Bag', '5kg Bulk', 'Drip Bag Box', 'Capsule Pack'])->random(),
                'Roast Date' => now()->subDays(rand(1, 14))->format('Y-m-d'),
                'Harvest Season' => collect(['Spring', 'Summer', 'Fall', 'Winter', 'Year-round'])->random(),
                'Certification' => collect(['Organic', 'Fair Trade', 'Rainforest Alliance', 'UTZ', 'Bird Friendly', 'Direct Trade', 'Specialty Grade'])->random(),
                'Cup Score' => rand(80, 95),
            ];

            $selectedSpecs = collect($specOptions)
                ->take(rand(7, 10))
                ->map(function ($value, $key) {
                    return [
                        'name' => $key,
                        'value' => $value,
                    ];
                })
                ->values()
                ->toArray();

            $finalPrice = $price - rand(1000, 15000);
            if ($finalPrice < $price * 0.7) {
                $finalPrice = intval($price * 0.8); // Ensure at least 20% discount maximum
            }

            $product = Product::create([
                'name' => $name,
                'slug' => $slug,
                'sku' => $baseSku,
                'shop_id' => $allShopIds[array_rand($allShopIds)],
                'meta_description' => 'Premium ' . $name . ' - High quality coffee with exceptional taste and aroma.',
                'long_description' => 'Experience the rich and complex flavors of ' . $name . '. This carefully selected coffee offers a unique taste profile that coffee enthusiasts will appreciate. Perfect for both brewing at home and professional use.',
                'price' => $price,
                'final_price' => $finalPrice,
                'has_variant' => $hasVariant,
                'tags' => collect($tags)->random(rand(2, 4))->toArray(),
                'specification' => $selectedSpecs,
                'stock' => 0,
                'is_featured' => rand(0, 100) < 25, // 25% chance of being featured
                'is_popular' => rand(0, 100) < 20,  // 20% chance of being popular
            ]);

            // Attach random categories (3-5 categories per product)
            if (!empty($allCategoryIds)) {
                $product->categories()->attach(collect($allCategoryIds)->random(rand(2, 5)));
            }

            $totalStock = 0;

            if ($hasVariant) {
                $roastValues = $variantMode === 1 || $variantMode === 3 ? $roastLevels : [null];
                $grindValues = $variantMode === 2 || $variantMode === 3 ? collect($grindSizes)->random(rand(2, 4)) : [null];

                foreach ($roastValues as $roast) {
                    foreach ($grindValues as $grind) {
                        $variantSku = $baseSku;
                        if ($roast) $variantSku .= '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $roast));
                        if ($grind) $variantSku .= '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $grind));

                        $stock = rand(3, 25);
                        $variantPrice = $price + rand(-2000, 8000);
                        $variantFinalPrice = $variantPrice - rand(500, 5000);

                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'sku' => $variantSku,
                            'price' => $variantPrice,
                            'final_price' => $variantFinalPrice,
                            'stock' => $stock,
                        ]);

                        if ($roast && $roastAttr) {
                            $roastVal = AttributeValue::where('attribute_id', $roastAttr->id)->where('value', $roast)->first();
                            if ($roastVal) {
                                $variant->attributeValues()->attach($roastVal->id, ['attribute_id' => $roastAttr->id]);
                            }
                        }

                        if ($grind && $grindAttr) {
                            $grindVal = AttributeValue::where('attribute_id', $grindAttr->id)->where('value', $grind)->first();
                            if ($grindVal) {
                                $variant->attributeValues()->attach($grindVal->id, ['attribute_id' => $grindAttr->id]);
                            }
                        }

                        $totalStock += $stock;
                    }
                }

                $product->update(['stock' => $totalStock]);
            } else {
                $stockAmount = rand(5, 50);
                $product->update(['stock' => $stockAmount]);
            }

            // Add product images (cycling through available images)
            $imageRand = rand(1, 15);
            $defaultImagePath = public_path('assets/imgs/shop/product-' . $imageRand . '-1.jpg');
            $hoverImagePath = public_path('assets/imgs/shop/product-' . $imageRand . '-2.jpg');

            if (file_exists($defaultImagePath)) {
                $product->addMedia($defaultImagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('default-image');
            }

            if (file_exists($hoverImagePath)) {
                $product->addMedia($hoverImagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('hover-image');
            }
        }

        $this->command->info('Successfully created ' . count($additionalProductNames) . ' additional products!');
    }
}
