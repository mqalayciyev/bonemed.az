<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $table = 'brand_product';
    protected $guarded = [];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
}
