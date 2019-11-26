<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $service =  new InvoiceService();
        $invoices = $service->find()->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function show($id){

        $invoice = DB::connection('legacy')
            ->table('tblinvoices')
            ->where('id', '=', $id)
            ->get()
            ->first();

        $itens = DB::connection('legacy')
            ->table('tblinvoiceitems')
            ->where('id', '=', $id)
            ->get();

        $details = DB::select( DB::raw("
        SELECT DISTINCT
    CONCAT (name, '(', f.context,')') AS produto,
                f.productid,
                f.invoiceid,
                f.context
FROM voxlink_whmcs_dev.tblproducts AS p
join voxlink_voip_report_dev.cdr_faturadas AS f on p.id = f.productid
WHERE f.invoiceid = 2
ORDER BY produto ASC;
"));


        return view('invoices.show', compact('invoice', 'itens', 'details'));
    }
}
