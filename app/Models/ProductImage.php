<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
