<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function getDurationAttribute(){
        return $this->end->diffInMinutes($this->start);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
