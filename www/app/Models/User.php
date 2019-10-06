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
}
