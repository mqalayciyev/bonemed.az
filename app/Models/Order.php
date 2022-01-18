<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'order';
    protected $fillable = [
        'cart_id', 'order_amount', 'status',
        'first_name', 'last_name', 'address', 'phone', 'mobile', 'bank', 'installment_number'
    ];

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
