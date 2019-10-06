<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model 
{
    protected $table = 'customer';
    
    protected $fillable = [
        'id',
        'id_company',
        'id_tbclient',
        'uuid_tbclient',
        'first_name',
        'last_name',
        'cpf',
        'email',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'country'
    ];
    
    public function customerUser()
    {
        return $this->belongsToMany('App\Model\CustomerUser', 'id' , 'id_customer');
        
    }
    
    public function company()
    {
        return $this->belongsTo('App\Model\Company', 'id_company', 'id');
    }
    
    
}
