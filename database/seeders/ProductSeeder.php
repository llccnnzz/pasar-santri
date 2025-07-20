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

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Milks and Dairies', 'icon' => 'assets/imgs/theme/icons/category-1.svg'],
            ['name' => 'Clothing & beauty', 'icon' => 'assets/imgs/theme/icons/category-3.svg'],
            ['name' => 'Pet foods & toy', 'icon' => 'assets/imgs/theme/icons/category-4.svg'],
            ['name' => 'Packaged fast food', 'icon' => 'assets/imgs/theme/icons/category-5.svg'],
            ['name' => 'Baking material', 'icon' => 'assets/imgs/theme/icons/category-6.svg'],
            ['name' => 'Vegetables & tubers', 'icon' => 'assets/imgs/theme/icons/category-7.svg'],
            ['name' => 'Noodles Rice', 'icon' => 'assets/imgs/theme/icons/category-8.svg'],
            ['name' => 'Fast food', 'icon' => 'assets/imgs/theme/icons/category-9.svg'],
            ['name' => 'Fresh seafood', 'icon' => 'assets/imgs/theme/icons/category-10.svg'],
            ['name' => 'Ice cream', 'icon' => 'assets/imgs/theme/icons/category-11.svg'],
        ];

        $allCategoryIds = [];
        foreach ($categories as $item) {
            $category = new Category();
            $category['name'] = $item['name'];
            $category->save();

            if (isset($item['icon'])) {
                $category->addMedia(public_path($item['icon']))->preservingOriginal()->toMediaCollection('icon');
            }

            $allCategoryIds[] = $category['id'];
        }

        $productNames = [
            'Ethiopian Yirgacheffe',
            'Colombian Supremo',
            'Sumatra Mandheling',
            'Kenya AA',
            'Guatemala Antigua',
            'Brazil Santos',
            'Tanzania Peaberry',
            'Costa Rica Tarrazu',
            'Honduras Marcala',
            'Panama Geisha',
            'Java Arabica',
            'Sulawesi Toraja',
            'Nicaragua Jinotega',
            'Vietnam Robusta',
            'Rwanda Bourbon',
            'Burundi Kayanza',
            'Mexico Chiapas',
            'Peru Cajamarca',
            'Indian Monsooned Malabar',
            'Papua New Guinea Sigri'
        ];
        $brands = [
            [
                'name' => 'Kopi Kenangan',
                'slug' => 'kopi-kenangan',
                'description' => 'Kopi Kenangan is a popular coffee chain in Indonesia, known for its high-quality coffee and unique blends.',
                'address' => 'Jl. Jend. Sudirman No.1, Jakarta',
                'phone' => '+62 21 1234 5678',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/kopikenangan',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/kopikenangan',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/kopikenangan',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Tomorrow',
                'slug' => 'tomorrow',
                'description' => 'Tomorrow is a modern coffee brand focusing on sustainability and quality sourcing.',
                'address' => 'Jl. Kebon Jeruk No.2, Jakarta',
                'phone' => '+62 21 2345 6789',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/tomorrowcoffee',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/tomorrowcoffee',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/tomorrowcoffee',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Tanamera',
                'slug' => 'tanamera',
                'description' => 'Tanamera is known for its specialty coffee sourced from various regions in Indonesia.',
                'address' => 'Jl. Melawai No.3, Jakarta',
                'phone' => '+62 21 3456 7890',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/tanameracoffee',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/tanameracoffee',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/tanameracoffee',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Anomali Coffee',
                'slug' => 'anomali-coffee',
                'description' => 'Anomali Coffee offers a wide range of Indonesian coffee beans and blends.',
                'address' => 'Jl. Senopati No.4, Jakarta',
                'phone' => '+62 21 4567 8901',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/anomalicoffee',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/anomalicoffee',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/anomalicoffee',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Fore Coffee',
                'slug' => 'fore-coffee',
                'description' => 'Fore Coffee is a trendy coffee brand with a focus on quality and innovation.',
                'address' => 'Jl. Panglima Polim No.5, Jakarta',
                'phone' => '+62 21 5678 9012',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/forecoffee',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/forecoffee',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/forecoffee',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Kapal Api',
                'slug' => 'kapal-api',
                'description' => 'Kapal Api is one of Indonesia\'s oldest and most recognized coffee brands, known for its rich flavors.',
                'address' => 'Jl. Raya Kapal Api No.6, Surabaya',
                'phone' => '+62 31 6789 0123',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/kapalapi',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/kapalapi',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/kapalapi',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Tuku',
                'slug' => 'tuku',
                'description' => 'Tuku is a coffee brand that emphasizes local sourcing and community engagement.',
                'address' => 'Jl. Cikini No.7, Jakarta',
                'phone' => '+62 21 7890 1234',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/tuku',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/tuku',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/tuku',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
            [
                'name' => 'Excelso',
                'slug' => 'excelso',
                'description' => 'Excelso is a premium coffee brand offering a wide range of blends and single-origin coffees.',
                'address' => 'Jl. Thamrin No.8, Jakarta',
                'phone' => '+62 21 8901 2345',
                'social_links' => json_encode([
                    [
                        'name'=> 'Facebook',
                        'url' => 'https://www.facebook.com/excelso',
                        'logo' => '/assets/imgs/theme/icons/social-fb.svg'
                    ],
                    [
                        'name'=> 'Instagram',
                        'url' => 'https://www.instagram.com/excelso',
                        'logo' => '/assets/imgs/theme/icons/social-insta.svg'
                    ],
                    [
                        'name'=> 'Twitter',
                        'url' => 'https://twitter.com/excelso',
                        'logo' => '/assets/imgs/theme/icons/social-tw.svg'
                    ]
                ]),
                'is_open' => true,
            ],
        ];

        foreach ($brands as $i => $brand) {
            $path = '/assets/imgs/vendor/vendor-'.($i+1).'.png';
            $shop = Shop::create($brand);
            $shop->addMedia(public_path($path))->preservingOriginal()->toMediaCollection('logo');
        }

        $allShopIds = Shop::pluck('id')->toArray();

        $tags = ['Arabica', 'Robusta', 'Single Origin', 'Espresso', 'Cold Brew', 'Drip Bag', 'Specialty Coffee', 'Decaf', 'Organic'];

        $roastAttr = Attribute::firstOrCreate(['name' => 'Roast Level']);
        $grindAttr = Attribute::firstOrCreate(['name' => 'Grind Size']);

        $roastLevels = ['Light', 'Medium', 'Dark'];
        $grindSizes = ['Whole Bean', 'Coarse', 'Medium', 'Fine'];

        foreach ($roastLevels as $roastLevel) {
            AttributeValue::firstOrCreate(['attribute_id' => $roastAttr->id, 'value' => $roastLevel]);
        }
        foreach ($grindSizes as $grindSize) {
            AttributeValue::firstOrCreate(['attribute_id' => $grindAttr->id, 'value' => $grindSize]);
        }

        foreach ($productNames as $name) {
            $slug = Str::slug($name) . '-' . time();
            $baseSku = strtoupper(Str::random(6));
            $price = rand(5000, 100000);

            $variantMode = rand(0, 3);

            $hasVariant = $variantMode > 0;

            $specOptions = [
                'Origin' => collect(['Ethiopia', 'Colombia', 'Sumatra', 'Kenya', 'Brazil', 'Guatemala', 'Vietnam', 'Panama', 'Peru', 'Yemen'])->random(),
                'Tasting Notes' => collect(['Floral', 'Citrus', 'Chocolate', 'Nutty', 'Fruity', 'Spicy', 'Earthy', 'Caramel'])->random(),
                'Processing Method' => collect(['Washed', 'Natural', 'Honey', 'Wet-Hulled'])->random(),
                'Altitude' => rand(1000, 2200) . ' masl',
                'Body' => collect(['Light', 'Medium', 'Full'])->random(),
                'Acidity' => collect(['Low', 'Medium', 'High'])->random(),
                'Caffeine Level' => collect(['Regular', 'Decaf'])->random(),
                'Packaging' => collect(['250g Bag', '500g Bag', '1kg Bag', 'Drip Bag'])->random(),
            ];

            $selectedSpecs = collect($specOptions)
                ->take(rand(6, 8))
                ->map(function ($value, $key) {
                    return [
                        'name' => $key,
                        'value' => $value,
                    ];
                })
                ->values()
                ->toArray();

            $product = Product::create([
                'name' => $name,
                'slug' => $slug,
                'sku' => $baseSku,
                'shop_id' => $allShopIds[array_rand($allShopIds)],
                'meta_description' => 'Sample meta description for ' . $name,
                'long_description' => 'Sample long description for ' . $name,
                'price' => $price,
                'final_price' => $price + rand(-5000, -2000),
                'has_variant' => $hasVariant,
                'tags' => [$tags[array_rand($tags)], $tags[array_rand($tags)]],
                'specification' => $selectedSpecs,
                'stock' => 0,
                'is_featured' => rand(0, 100) < 30, // 30% chance of being featured
                'is_popular' => rand(0, 100) < 25,  // 25% chance of being popular
            ]);

            $product->categories()->attach(collect($allCategoryIds)->random(rand(3, 6)));

            $totalStock = 0;

            if ($hasVariant) {
                $roastValues = $variantMode === 1 || $variantMode === 3 ? $roastLevels : [null];
                $grindValues = $variantMode === 2 || $variantMode === 3 ? collect($grindSizes)->random(rand(2, 4)) : [null];

                foreach ($roastValues as $roast) {
                    foreach ($grindValues as $grind) {
                        $variantSku = $baseSku;
                        if ($roast) $variantSku .= '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $roast));
                        if ($grind) $variantSku .= '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $grind));

                        $stock = rand(5, 20);

                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'sku' => $variantSku,
                            'price' => $price + rand(0, 5000),
                            'final_price' => $price + rand(-5000, -2000),
                            'stock' => $stock,
                        ]);

                        if ($roast) {
                            $roastVal = AttributeValue::where('attribute_id', $roastAttr->id)->where('value', $roast)->first();
                            $variant->attributeValues()->attach($roastVal->id, ['attribute_id' => $roastAttr->id]);
                        }

                        if ($grind) {
                            $grindVal = AttributeValue::where('attribute_id', $grindAttr->id)->where('value', $grind)->first();
                            $variant->attributeValues()->attach($grindVal->id, ['attribute_id' => $grindAttr->id]);
                        }

                        $totalStock += $stock;
                    }
                }

                $product->update(['stock' => $totalStock]);
            } else {
                $product->update([
                    'stock' => rand(10, 30)
                ]);
            }

            $imageRand = rand(1, 15);
            $product->addMedia(public_path('assets/imgs/shop/product-' . $imageRand . '-1.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('default-image');

            $product->addMedia(public_path('assets/imgs/shop/product-' . $imageRand . '-2.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('hover-image');
        }
    }
}
