<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Ensure you import the Product model

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example: Inserting multiple records into the products table
        Product::insert([
            [
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'price' => 100.00,
                'quantity' => 10,
                'category_id' => 1,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for product 2',
                'price' => 150.00,
                'quantity' => 5,
                'category_id' => 2,
            ],
            // You can add more products here
        ]);
    }
}
