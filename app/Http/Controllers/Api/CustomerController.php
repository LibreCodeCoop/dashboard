<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Customer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(DataTables $dataTables, Request $request)
    {
        $query = $dataTables->eloquent(Customer::query()->with('typeable'));

        $query->addIndexColumn()
            ->addColumn('name', function ($user) { return $user->name; } )
            ->addColumn('document', function ($user) { return $user->document; } )
            ->filter(function ($query) use ($request) {
                if($request->filled('columns.1.search.value')) {
                    $name = $request->input('columns.1.search.value');

                    $query->whereHasMorph('typeable', ["App\\Company", "App\\User"], function ($query, $type) use ($name){
                        if($type === "App\\Company") $query->where('social_reason', 'like', "%$name%");
                        else $query->where('name', 'like', "%$name%");
                    });
                }

                if($request->filled('columns.2.search.value')) {
                    $document = $request->input('columns.2.search.value');

                    $query->whereHasMorph('typeable', ["App\\Company", "App\\User"], function ($query, $type) use ($document){
                        if($type === "App\\Company") $query->where('cnpj', 'like', "%$document%");
                        else $query->where('cpf', 'like', "%$document%");
                    });
                }

            }, true)

            ->addColumn('action', function ($customer) {
                return
                    "<form action='" . route('user.destroy', $customer) . "' method='post' class='user-form'>
                      " . csrf_field() . "
                      " . method_field('delete') . "
                      <a rel='tooltip' class='btn btn-success btn-link' href='" . route('customer.edit', $customer) ."' data-original-title='' title=''>
                        <i class='material-icons'>edit</i>
                        <div class='ripple-container'></div>
                      </a>
                      <button type='button' class='btn btn-danger btn-link' data-original-title='' title=''
                          onclick=\"confirm('" . __("Are you sure you want to delete this user?") . " ') ? submitExcludeUser(this.parentElement) : ''\">
                          <i class='material-icons'>close</i>
                          <div class='ripple-container'></div>
                      </button>
                 </form>";
            });

        return $query->make(true);

    }
}
