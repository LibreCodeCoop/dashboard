<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Customer $model)
    {
        return Customer::with('typeable')->get();

    }
}
