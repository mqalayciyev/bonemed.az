<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'product';
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_product');
    }

    public function suppliers()
    {
        return $this->belongsToMany('App\Models\Supplier', 'supplier_product');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'tag_product');
    }

    public function brands()
    {
        return $this->belongsToMany('App\Models\Brand', 'brand_product');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\ProductDetail');
    }

    public function rating()
    {
        return $this->hasOne('App\Models\Rating');
    }

    public function image()
    {
        return $this->hasOne('App\Models\ProductImage')->withDefault();
    }
}
