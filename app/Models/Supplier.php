<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'supplier';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'supplier_product');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
