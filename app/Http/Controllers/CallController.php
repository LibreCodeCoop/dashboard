<?php

namespace App\Http\Controllers;

use App\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $model)
    {
        $currentUser = Auth::user();
        $userCustomers = $currentUser->customers;

        if($currentUser->customer) $userCustomers->add($currentUser->customer);

        $calls = $model
            ->whereIn(
                'customer_id',
                $userCustomers->map(function($c) {
                    return $c->id;
                })
            )
            ->with('customer')
            ->orderBy('start')
            ->paginate(15);

        return view('calls.index', ['calls' => $calls]);
    }
}
