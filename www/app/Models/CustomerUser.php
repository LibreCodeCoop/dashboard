<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerUser extends Model
{
    protected $table = 'customer_user';
    
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
