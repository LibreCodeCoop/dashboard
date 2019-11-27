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
