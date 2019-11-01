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
}
