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
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->timestamps();
        });
        //insert data
        DB::table('products')->insert([
            [
                'name' => 'dell vostro',
                'description' => 'Máy tính',
                'price' => '3000',
                'quantity' => '9'
            ],
            [
                'name' => 'dell inspiron',
                'description' => 'Máy tính',
                'price' => '2000',
                'quantity' => '7'
            ],
            [
                'name' => ' inspiron 3',
                'description' => 'Máy tính',
                'price' => '24242',
                'quantity' => '4'
            ],
            [
                'name' => 'ip16',
                'description' => 'iphone',
                'price' => '20000',
                'quantity' => '12'
            ],
            [
                'name' => 'ip15 promax',
                'description' => 'iphone',
                'price' => '30000',
                'quantity' => '7'
            ],
            [
                'name' => 'ip 14 pro',
                'description' => 'iphone',
                'price' => '20000',
                'quantity' => '23'
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
