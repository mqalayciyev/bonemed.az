<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    use SoftDeletes;
    protected $table = 'wish_list';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
