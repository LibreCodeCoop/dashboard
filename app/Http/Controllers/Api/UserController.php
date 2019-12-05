<?php
namespace App\Http\Controllers\Api;

use App\Services\CallService;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController
{
    public function index(DataTables $dataTables, Request $request){

//        $user = $request->user();
//        $user = (!$user->is_admin)? $user : null;
        $query = $dataTables->eloquent(User::query());

        $query->addIndexColumn()
            ->addColumn('action', function ($user) {
                return
                "<form action='" . route('user.destroy', $user) . "' method='post'>
                      " . csrf_field() . "
                      " . method_field('delete') . "
                      <a rel='tooltip' class='btn btn-success btn-link' href='" . route('user.edit', $user) ."' data-original-title='' title=''>
                        <i class='material-icons'>edit</i>
                        <div class='ripple-container'></div>
                      </a>
                      <button type='button' class='btn btn-danger btn-link' data-original-title='' title='' onclick=\"confirm('" . __("Are you sure you want to delete this user?") . " ') ? this.parentElement.submit() : ''\">
                          <i class='material-icons'>close</i>
                          <div class='ripple-container'></div>
                      </button>
                 </form>";
            });

        return $query->make(true);
    }
}
