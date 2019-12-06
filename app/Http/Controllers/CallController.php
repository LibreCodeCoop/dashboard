<?php

namespace App\Http\Controllers;

use App\Call;
use App\Services\CallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        return view('calls.index', compact('userId'));
    }
}
