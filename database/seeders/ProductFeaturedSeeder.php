<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductFeaturedSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Set some random products as featured
        Product::inRandomOrder()->limit(10)->update(['is_featured' => true]);
        
        // Set some random products as popular
        Product::inRandomOrder()->limit(8)->update(['is_popular' => true]);
        
        $this->command->info('Products marked as featured and popular successfully!');
    }
}
