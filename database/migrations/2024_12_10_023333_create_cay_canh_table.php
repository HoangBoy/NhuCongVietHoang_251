<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cay_canh', function (Blueprint $table) {
        $table->id();
        $table->string('ten_cay');
        $table->string('mo_ta')->nullable();
        $table->integer('so_luong');
        $table->decimal('gia', 10, 2);
        $table->date('ngay_tao')->nullable();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cay_canh');
    }
};
