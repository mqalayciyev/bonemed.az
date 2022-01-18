<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'category';
    //protected $fillable = ['category_name', 'slug'];
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'category_product');
    }

    public function top_category()
    {
        return $this->belongsTo('App\Models\Category', 'top_id')->withDefault([
            'category_name' => __('admin.Parent Category')
        ]);
    }

    public function alt_category(){
        return $this->hasMany('App\Models\Category','top_id','id') ;
    }

}
