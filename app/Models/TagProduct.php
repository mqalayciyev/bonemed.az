<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagProduct extends Model
{
    use SoftDeletes;
    protected $table = 'tag_product';
    protected $guarded = [];
    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }
}
