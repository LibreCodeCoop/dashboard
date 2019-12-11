<?php

namespace App\Http\Controllers\Api;

use App\Services\InvoiceService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index(DataTables $dataTables, Request $request)
    {
        $service =  new InvoiceService();
        $user = $request->user();
        $user = (!$user->is_admin)? $user : null;
        $query = $dataTables->query($service->find($user))
            ->addIndexColumn()
            ->addColumn('action', function ($invoice) {
                return '<a href="' . route('invoice.show', ['invoice' => $invoice->invoice_code ]) . '" >' .  __('Show Invoice').'<i class="material-icons">insert_drive_file</i></a>';
            });

        return $query->make(true);
    }
}
