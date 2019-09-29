<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Company
 *
 * @author samuel
 */
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
        return $this->hasOne('App\Model\Customer', 'id', 'id_company');
        
    }
}
