<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'user';
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'password', 'activation_key', 'is_active', 'is_manage'];
    protected $hidden = ['password', 'activation_key'];

    public function detail()
    {
        return $this->hasOne('App\Models\UserDetail')->withDefault();
    }
}
