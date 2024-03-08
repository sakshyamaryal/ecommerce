<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 products with the same image
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => Str::random(50),
                'description' => Str::random(200),
                'price' => rand(1000, 50000) / 100, // Random price between 10.00 and 500.00
                'available_stock' => rand(1, 50), // Random available stock between 1 and 50
                'is_active' => 1,
                'image' => '0_1709881481.jpg',
            ]);
        }
    }
}
