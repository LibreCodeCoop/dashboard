<?php
namespace App\Http\Controllers\Api;

use App\Services\CallService;
use Yajra\DataTables\DataTables;

class CallController
{
    public function index(DataTables $dataTables){
        $service =  new CallService();
        $query = $dataTables->query($service->find());

        $query->addIndexColumn()
            ->addColumn('action', function ($invoice) {
                return '<a href="' . route('invoice.show', ['invoice' => $invoice->us_id ]) . '" >' .  __('Show Invoice').'<i class="material-icons">insert_drive_file</i></a>';
            });

        return $query->make(true);
    }
}
