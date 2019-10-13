<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'master',
        'admin'
    ];

    public function menu()
    {
        return $this->hasMany('App\Models\Menu', 'id_user');
    }

    public function customeruser()
    {
        return $this->belongsToMany('App\Models\CustomerUser', 'id', 'id_customer');
    }

}
