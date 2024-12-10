<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cay_canh', function (Blueprint $table) {
            $table->id();
            $table->string('ma_cay', 50)->unique();
            $table->string('ten_cay');
            $table->text('mo_ta')->nullable();
            $table->integer('so_luong')->default(0);
            $table->decimal('gia', 10, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cay_canhs');
    }
};
