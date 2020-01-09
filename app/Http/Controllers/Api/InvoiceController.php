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
                $html[]= '<a data-toggle="modal" data-target="#modalInvoice" href="#modalInvoice" data-remote="' . route('invoice.show', ['invoice' => $invoice->invoice_code ]) . '" ><i class="material-icons">pageview</i></a>';
                if ($invoice->has_billet) {
                    $html[]= '<a target="_blank" href="' . route('invoice.billet', ['invoice' => $invoice->invoice_code ]) . '" ><i class="material-icons">attach_money</i></a>';
                }
                $html[]= '<a class="invoice-print" target="_blank" href="' . route('invoice.show', ['invoice' => $invoice->invoice_code ]) . '?print=true" ><i class="material-icons">print</i></a>';
                $html[]= '<a href="' . route('invoice.csv', ['invoice' => $invoice->invoice_code ]) . '" ><i class="material-icons">cloud_download</i></a>';
                return implode(' | ', $html);
            })
            ->filterColumn('client', function(Builder $builder, $keyword) {
                $builder->where('customer_id', '=', $keyword);
            })
            ->filterColumn('date', function(Builder $builder, $keyword) {
                $keyword = explode('|', $keyword);
                if ($keyword[0]) {
                    $builder->where('date', '>=', $keyword[0]);
                }
                if ($keyword[1]) {
                    $builder->where('date', '<=', $keyword[0]);
                }
            })
            ->filterColumn('duedate', function(Builder $builder, $keyword) {
                $keyword = explode('|', $keyword);
                if ($keyword[0]) {
                    $builder->where('duedate', '>=', $keyword[0]);
                }
                if ($keyword[1]) {
                    $builder->where('duedate', '<=', $keyword[0]);
                }
            });

        return $query->make(true);
    }
}
