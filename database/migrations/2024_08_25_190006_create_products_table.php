<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->timestamps();
        });
        // Insert dữ liệu vào bảng `products`
        DB::table('products')->insert([
            [
                'name' => 'Dell Vostro',
                'description' => 'Máy tính xách tay',
                'price' => 3000,
                'quantity' => 9,
                'image' => 'dell_vostro.png',
                'category_id' => 1 // Assuming 'Máy tính' has id 1
            ],
            [
                'name' => 'Dell Inspiron',
                'description' => 'Máy tính xách tay',
                'price' => 2000,
                'quantity' => 7,
                'image' => 'dell_inspiron.png',
                'category_id' => 1
            ],
            [
                'name' => 'Inspiron 3',
                'description' => 'Máy tính xách tay',
                'price' => 24242,
                'quantity' => 4,
                'image' => 'inspiron_3.png',
                'category_id' => 1
            ],
            [
                'name' => 'iPhone 16',
                'description' => 'iPhone mới nhất',
                'price' => 20000,
                'quantity' => 12,
                'image' => 'iphone_16.png',
                'category_id' => 4 // Assuming 'iphone' has id 4
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'iPhone đời mới',
                'price' => 30000,
                'quantity' => 7,
                'image' => 'iphone_15_pro_max.png',
                'category_id' => 4
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'iPhone đời cũ hơn',
                'price' => 20000,
                'quantity' => 23,
                'image' => 'iphone_14_pro.png',
                'category_id' => 4
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
