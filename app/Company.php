<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'social_reason', 'municipal_registration', 'state', 'phone', 'address'
    ];


    public function customer()
    {
        return $this->morphOne(Customer::class, 'typeable');
    }
}
