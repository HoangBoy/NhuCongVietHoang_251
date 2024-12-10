<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CayCanh extends Model
{
    use HasFactory;

    protected $table = 'cay_canh'; // Tên bảng trong database

    protected $fillable = [
        'ten_cay',
        'mo_ta',
        'so_luong',
        'gia',
        'ngay_tao',
    ];
}
