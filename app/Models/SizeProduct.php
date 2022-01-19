<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SizeProduct extends Model
{
    // use SoftDeletes;
    protected $table = 'size_product';
    protected $guarded = [];
    public $timestamps = false;


    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }
}
