<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'user_menu';

    protected $fillable = [
        'id',
        'name',
        'id_user',
        'link'
    ];

    public function menu()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
