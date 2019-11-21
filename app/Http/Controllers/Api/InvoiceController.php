<?php

namespace App\Http\Controllers\Api;

use App\Services\InvoiceService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index(DataTables $dataTables)
    {
        $service =  new InvoiceService();
        return $dataTables->query($service->find())
            ->addColumn('action', function ($invoice) {
                return '<a href="#edit-' . 1 . '" ><i class="material-icons">edit</i></a>';
            })
            ->make(true);
    }
}
