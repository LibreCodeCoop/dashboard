<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Company extends Model 
{
    protected $table = 'company';
    
    protected  $fillable = [
        'id',
        'name',
        'cnpj',
        'municipal_reg',
        'state_reg',
        'email',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'country'
    ];
    
    public function customer()
    {
        return $this->hasOne('App\Model\Customer',  'id_company', 'id');
        
    }
}
