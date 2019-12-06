<?php
namespace App\Http\Controllers\Api;

use App\Services\CallService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CallController
{
    public function index(DataTables $dataTables, Request $request, CallService $service){

        $user = $request->user();
        $user = (!$user->is_admin)? $user : null;
        $query = $dataTables->query($service->find($user));

        $query->addIndexColumn()
            ->addColumn('action', function ($call) {
                return
                "<button type='button' class='btn btn-link' data-original-title='' title='' onclick='showPlayerModal(\"$call->path_s3\")'>
                    <i class='material-icons'>play_circle_outline</i>
                    <div class='ripple-container'></div>
                   </button>
                  <button type='button' class='btn btn-link' data-original-title='' title='' onclick='alert(\"" . __('Download Call is an test, Nothing will happen')."\")'>
                      <i class='material-icons'>cloud_download</i>
                      <div class='ripple-container'></div>
                 </button>";
            });

        return $query->make(true);
    }
}
