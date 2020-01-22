<?php
namespace App\Http\Controllers\Api;

use App\Customer;
use App\Services\CallService;
use Illuminate\Database\Query\Builder;
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
                if ($call->uuid) {
                    return
                    "<button type='button' class='btn btn-link' data-original-title='' title='' onclick='showPlayerModal(\"$call->uuid\")'>
                        <i class='material-icons'>play_circle_outline</i>
                        <div class='ripple-container'></div>
                    </button>
                    <button type='button' class='btn btn-link' data-original-title='' title='' onclick='downloadAudio(\"$call->uuid\")'>
                        <i class='material-icons'>cloud_download</i>
                        <div class='ripple-container'></div>
                    </button>";
                }
            })
            ->filterColumn('origin_number', function(Builder $builder, $keyword) {
                $builder->where('cdr.caller_id_number', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('destination_number', function(Builder $builder, $keyword) {
                $builder->where('cdr.destination_number', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('start_time', function(Builder $builder, $keyword) {
                $keyword = explode('|', $keyword);
                if ($keyword[0]) {
                    $builder->where('cdr.start_stamp', '>=', $keyword[0]);
                }
                if ($keyword[1]) {
                    $builder->where('cdr.start_stamp', '<=', $keyword[1]);
                }
            })
            ->filterColumn('client', function(Builder $builder, $keyword) {
                $builder->where('client.id', '=', $keyword);
            })
            ->filterColumn('domain', function(Builder $builder, $keyword) {
                $builder->where('client.domain', '=', $keyword);
            });

        $return = $query->make(true);
        $data = $this->setDomainFilter($return->getData(), $request);
        return $return->setData($data);
    }

    private function setDomainFilter($data, $request)
    {
        $user = $request->user();
        $columns = $request->get('columns');
        $customers = [];
        foreach ($columns as $parameter) {
            if ($parameter['name'] == 'client' && $parameter['search']['value']) {
                $customers = [(int)$parameter['search']['value']];
                break;
            }
        }
        if (!$customers) {
            if ($user->is_admin) {
                foreach (Customer::all() as $customer) {
                    $customers[] = $customer->id;
                }
            } else {
                $user->customers->load('typeable');
                foreach($user->customers as $customer) {
                    $customers[] = $customer->id;
                }
            }
        }
        if ($customers) {
            $domains = (new CallService())->findDomainsByCustomerId($user, $customers)->all();
            if (count($domains) > 1) {
                $data->dataDomains = $domains;
            }
        }
        return $data;
    }
}
