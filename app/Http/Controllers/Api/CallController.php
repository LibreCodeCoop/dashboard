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
                $call->uuid = '9089dd5f-8eb0-4029-98d3-8a26608517bc';
                if($call->uuid){
                    $url = route('call.audio',['uuid' => $call->uuid]);
                    return
                        "<button type='button' class='btn btn-link' data-original-title='' title='' onclick='showPlayerModal(this)' data-url='$url'>
                    <i class='material-icons'>play_circle_outline</i>
                    <div class='ripple-container'></div>
                   </button>
                  <a type='button' class='btn btn-link' data-original-title='' title='' href='$url'>
                      <i class='material-icons'>cloud_download</i>
                      <div class='ripple-container'></div>
                 </a>";

                }
                return __("No audio");
            });

        return $query->make(true);
    }
}
