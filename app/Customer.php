<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

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
        if ($this->typeable_type != 'App\Company' && $this->typeable == null ) throw new Exception($this);
        return ($this->typeable_type == 'App\Company')? $this->typeable->social_reason : $this->typeable->name;
    }

    public function getDocumentAttribute(){
        return ($this->typeable_type == 'App\Company')? $this->typeable->cnpj : $this->typeable->cpf;
    }
}
