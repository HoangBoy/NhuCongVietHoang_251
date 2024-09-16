<?php

// database/migrations/xxxx_xx_xx_create_cart_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        // Schema::create('cart_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('cart_id')->index();
        //     $table->unsignedBigInteger('product_id')->index();
        //     $table->integer('quantity');
        //     $table->timestamps();

        //     // Tạo khoá ngoại
        //     $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        //     $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        // });
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}

