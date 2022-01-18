<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    protected $table = 'tag';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'tag_product');
    }
}
