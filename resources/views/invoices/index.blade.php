@extends('layouts.app', ['activePage' => 'invoice-listing', 'titlePage' => __('Invoice Listing')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Invoices') }}</h4>
                <p class="card-category"> {{ __('Here you can manage invoices') }}</p>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    <th>
                        {{ __('Customer') }}
                    </th>
                    <th>
                        {{ __('Date') }}
                    </th>
                    <th>
                        {{ __('Due Date') }}
                    </th>
                        <th>
                            {{ __('Total') }}
                        </th>
                      <th>
                          {{ __('Code') }}
                      </th>
                    <th>
                        {{ __('Status') }}
                    </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($invoices as $call)
                        <tr>
                            <td>
                                {{ $call->client }}
                            </td>
                            <td>
                                {{ $call->date }}
                            </td>
                          <td>
                            {{ $call->duedate }}
                          </td>
                          <td>
                            R$ {{ number_format($call->total, 2, ',', '.') }}
                          </td>
                          <td>
                            {{ $call->code }}
                          </td>
                            <td>
                                <span class="badge badge-@switch($call->status)
                                @case('Em atraso')danger @break
                                @case('Em aberto')warning @break
                                @case('Pago')success @break
                                @case('Cancelada')default @break
                                @endswitch">{{ $call->status }}</span>
                            </td>
                          <td class="td-actions text-right">
                          <button type="button" class="btn btn-link" data-original-title="" title="" onclick="alert('{{ __("Show invoice is an test, Nothing will happen") }}') ">
                              <i class="material-icons">cloud_download</i>
                              <div class="ripple-container"></div>
                          </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{ $invoices->links() }}
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
