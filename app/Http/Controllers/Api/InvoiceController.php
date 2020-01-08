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
                $html[]= '<a data-toggle="modal" data-target="#modalInvoice" href="#modalInvoice" data-remote="' . route('invoice.show', ['invoice' => $invoice->invoice_code ]) . '" >' .  __('Show Invoice').'</a>';
                if ($invoice->has_billet) {
                    $html[]= '<a target="_blank" href="' . route('invoice.billet', ['invoice' => $invoice->invoice_code ]) . '" >' .  __('Billet').'</a>';
                }
                $html[]= '<a class="invoice-print" target="_blank" href="' . route('invoice.show', ['invoice' => $invoice->invoice_code ]) . '?print=true" >' .  __('Print').'</a>';
                $html[]= '<a href="' . route('invoice.csv', ['invoice' => $invoice->invoice_code ]) . '" >' .  __('CSV').'</a>';
                return implode(' | ', $html);
            });

        return $query->make(true);
    }
}
