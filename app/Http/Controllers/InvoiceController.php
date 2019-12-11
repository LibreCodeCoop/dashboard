<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        return view('invoices.index', compact('userId'));
    }

    public function show($id){
        $invoice = DB::connection('legacy')
            ->table('tblinvoices')
            ->where('id', '=', $id)
            ->get()
            ->first();

        $customer =  Customer::where('code', '=', $invoice->userid)->get()->first();

        $itens = DB::connection('legacy')
            ->table('tblinvoiceitems')
            ->where('id', '=', $id)
            ->get();

        $products = DB::select( DB::raw("
        SELECT DISTINCT
            CONCAT (name, '(', f.context,')') AS product,
            f.productid,
            f.invoiceid,
            f.context
        FROM voxlink_whmcs_dev.tblproducts AS p
        join voxlink_voip_report_dev.cdr_faturadas AS f on p.id = f.productid
        WHERE f.invoiceid = {$id}
        ORDER BY product ASC;
        "));

        foreach ($products as $product){
            ;
            $product->details = DB::select( DB::raw("
            SELECT
                datahora,
                origem,
                destino,
                RIGHT(tarifa,
                      LENGTH(tarifa) - INSTR(tarifa, '/')) AS tarifa,
                duracao,
                duracao_faturado,
                valor_faturado
            FROM
                voxlink_voip_report_dev.cdr_faturadas
            WHERE
                invoiceid = $id AND context = '$product->context'
            ORDER BY datahora ASC
            "));

            $product->total_duration = array_reduce($product->details, function($carry, $item){
                return $carry += $item->duracao;
            });

            $product->total_excedent = array_reduce($product->details, function($carry, $item){
                return $carry += $item->duracao_faturado;
            });
        }

        return view('invoices.show', compact('invoice', 'itens', 'products', 'customer'));
    }
}
