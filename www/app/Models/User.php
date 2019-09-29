<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of User
 *
 * @author samuel
 */
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

    public function customerUser()
    {
        return $this->belongsToMany('App\Model\CustomerUser',  'id_user', 'id');
    }
    
}
