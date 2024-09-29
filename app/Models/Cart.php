<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];
    

    // Giả sử bạn đã có cart_id
    //$cart = Cart::find($cartId);
    //$items = $cart->items; // Truy cập tất cả các CartItem liên quan
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
