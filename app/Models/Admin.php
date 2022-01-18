<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'admin';
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'password', 'activation_key', 'is_active', 'is_manage', 'address', 'city', 'state', 'country', 'zip_code', 'phone'];
    protected $hidden = ['password', 'activation_key'];
    public function site()
    {
        return $this->hasOne('App\Models\Site');
    }
}
