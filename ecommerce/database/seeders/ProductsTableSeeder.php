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
                'name' => 'Product '. $i,
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                'price' => rand(1000, 50000) / 100, // Random price between 10.00 and 500.00
                'available_stock' => rand(1, 50), // Random available stock between 1 and 50
                'is_active' => 1,
                'image' => '0_1710002677.jpg,0_1710002677.jpg,0_1710002677.jpg',
                'added_by' => $i,
            ]);
        }
    }
}
