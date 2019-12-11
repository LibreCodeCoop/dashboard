<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\User;

class UserCustomersController extends Controller
{
    public function index(User $user)
    {
        $user->customers->load('typeable');

        $customersRaw = ($user->is_admin)? Customer::all() : $user->customers;

        $customers = $customersRaw->map(function ($customer){
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
