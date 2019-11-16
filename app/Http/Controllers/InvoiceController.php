<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function index()
    {
        $service =  new InvoiceService();
        $invoices = $service->find()->paginate(15);

        return view('invoices.index', compact('invoices'));
    }
}
