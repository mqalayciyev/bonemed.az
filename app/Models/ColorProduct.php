<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorProduct extends Model
{
    // use SoftDeletes;
    protected $table = 'color_product';
    protected $guarded = [];
    public $timestamps = false;

    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

}
