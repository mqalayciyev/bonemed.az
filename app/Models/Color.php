<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    // use SoftDeletes;
    protected $table = 'color';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'color_product');
    }
    public function color_products()
    {
        return $this->hasOne('App\Models\ColorProduct')->withDefault();
    }
}
