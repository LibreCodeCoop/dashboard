<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(DataTables $dataTables, Request $request)
    {

        $service =  new CustomerService();
        $query = $dataTables->query($service->find());
        $query
            ->addColumn('action', function ($customer) {
                return
                    "<form action='" . route('customer.destroy', [$customer->id]) . "' method='post' class='user-form'>
                      " . csrf_field() . "
                      " . method_field('delete') . "
                      <a rel='tooltip' class='btn btn-success btn-link' href='" . route('customer.edit', [$customer->id]) ."' data-original-title='' title=''>
                        <i class='material-icons'>edit</i>
                        <div class='ripple-container'></div>
                      </a>
                      <button type='button' class='btn btn-danger btn-link' data-original-title='' title=''
                          onclick=\"confirm('" . __("Are you sure you want to delete this user?") . " ') ? submitExcludeUser(this.parentElement) : ''\">
                          <i class='material-icons'>close</i>
                          <div class='ripple-container'></div>
                      </button>
                 </form>";
            })
            ->filterColumn('name', function(Builder $builder, $keyword) {
                $builder->where('co.social_reason', 'like', '%'.$keyword.'%');
                $builder->orWhere('u.name', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('document', function(Builder $builder, $keyword) {
                $builder->where('co.cnpj', 'like', '%'.$keyword.'%');
                $builder->orWhere('u.cpf', 'like', '%'.$keyword.'%');
            });

        return $query->make(true);

    }
}
