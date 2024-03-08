<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the number of orders you want to create
        $numberOfOrders = 10;

        // Loop to create orders
        for ($i = 0; $i < $numberOfOrders; $i++) {
            // Generate random product_id and user_id
            $productId = rand(1, 10); 
            $userId = rand(1, 2);    

            
            $status = rand(0, 1) ? 'created' : 'completed';

            // Generate created_at and updated_at timestamps
            $createdAt = now();
            $updatedAt = now();

            // Insert order into database
            DB::table('orders')->insert([
                'product_id' => $productId,
                'user_id' => $userId,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
