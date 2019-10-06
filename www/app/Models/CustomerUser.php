<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CustomerUser
 *W
 * @author samuel
 */
class CustomerUser extends Model 
{
    protected  $table = 'customer_user';
    
    protected $fillable = [
        'id_user',
        'id_customer'
    ];
    
    
    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
    
    public function customer()
    {
        return $this->belongsToMany('App\Models\Customer', 'id_customer', 'id');
    }
}
