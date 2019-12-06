<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UserCustomersController extends Controller
{
    public function index(User $user)
    {
        $user->customers->load('typeable');

        $customers = $user->customers->map(function ($customer){
            return [
                "id" => $customer->id,
                "code" => $customer->code,
                "name" => $customer->name,
                "document" => $customer->document,
            ];
        });

        return $customers;
    }
}
