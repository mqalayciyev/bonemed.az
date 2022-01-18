<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'cart';
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

    public function cart_products()
    {
        return $this->hasMany('App\Models\CartProduct');
    }

    public static function active_cart_id()
    {
        $active_cart = DB::table('cart as c')
            ->leftJoin('order as o', 'o.cart_id', '=', 'c.id')
            ->where('c.user_id', auth()->id())
            ->whereRaw('o.id is null')
            ->orderByDesc('c.created_at')
            ->select('c.id')
            ->first();
        if (!is_null($active_cart)) return $active_cart->id;
    }

    public function cart_product_piece()
    {
        return DB::table('cart_product')->where('cart_id', $this->id)->sum('piece');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
