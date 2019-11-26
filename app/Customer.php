<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'code',
    ];

    public function typeable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    public function getNameAttribute(){
        return ($this->typeable_type == 'App\Company')? $this->typeable->social_reason : $this->typeable->name;
    }

    public function getDocumentAttribute(){
        return ($this->typeable_type == 'App\Company')? $this->typeable->cnpj : $this->typeable->cpf;
    }
}
