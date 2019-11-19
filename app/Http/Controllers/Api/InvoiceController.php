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
        return $dataTables->query($service->find())->toJson();
    }
}
