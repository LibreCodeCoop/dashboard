<?php
namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController
{
    public function index(DataTables $dataTables, Request $request){

        $user = Auth::guard('api')->user();

        $query = User::query();
        $query->select('users.id', 'users.name', 'users.email', 'users.created_at',
                DB::raw('CASE WHEN customers.id IS NOT NULL THEN 1 ELSE 0 END as `primary`')
            )
            ->leftJoin(DB::raw('customers'), function($join) {
                $join->on('customers.typeable_id', '=', 'users.id');
                $join->on('customers.typeable_type', '=', DB::raw("'App\\\\User'"));
            });
        $row = $query->get();

        $query = $dataTables->eloquent($query);
        $query->addIndexColumn()
            ->addColumn('customers', function ($user) {
                return $user->customers->map(function ($c) {
                    return $c->name;
                })->filter(function ($name) {
                    return trim($name);
                })->implode(' | ');
            })
            ->addColumn('action', function ($row) use($user) {
                $html = "<form action='" . route('user.destroy', $row) . "' method='post' class='user-form'>";
                $html.= csrf_field();
                $html.= method_field('delete');
                $html.= "
                      <a rel='tooltip' class='btn btn-success btn-link' href='" . route('user.edit', $row) ."' data-original-title='' title=''>
                        <i class='material-icons'>edit</i>
                        <div class='ripple-container'></div>
                      </a>";
                if (!$row->primary && $row->id != $user->id) {
                    $html.= "
                        <button type='button' class='btn btn-danger btn-link' data-original-title='' title=''
                            onclick=\"confirm('" . __("Are you sure you want to delete this user?") . " ') ? submitExcludeUser(this.parentElement) : ''\">
                            <i class='material-icons'>close</i>
                            <div class='ripple-container'></div>
                        </button>";
                }
                $html.= "</form>";
                return $html;
            });

        return $query->make(true);
    }
}
