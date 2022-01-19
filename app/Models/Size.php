<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    // use SoftDeletes;
    protected $table = 'size';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'size_product');
    }
    public function size_products()
    {
        return $this->hasOne('App\Models\SizeProduct')->withDefault();
    }
}
