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
                <div class="row">
                  @if (!empty($customers))
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="customer">{{ __('Customer') }}</label>
                    <select id="customer" class="form-control custom-select" name="customer">
                      <option value="" selected>{{ __('All') }}</option>
                      @foreach($customers as $id => $name)
                          <option value="{{$id}}"  {{ $id == old("customer") }} >{{ $name }}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="from-date">{{ __('Date') }}</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="from-date">{{__('From')}}</label>
                      </div>
                      <input type="date" class="form-control" id="from-date">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="to-date">{{__('To')}}</label>
                      </div>
                      <input type="date" class="form-control" id="to-date">
                    </div>
                  </div>
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="from-duedate">{{ __('Due Date') }}</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="from-duedate">{{__('From')}}</label>
                      </div>
                      <input type="date" class="form-control" id="from-duedate">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="to-duedate">{{__('To')}}</label>
                      </div>
                      <input type="date" class="form-control" id="to-duedate">
                    </div>
                  </div>
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="status">{{ __('Status') }}</label>
                    <select id="status" class="form-control custom-select" name="status">
                      <option value="" selected>{{ __('All') }}</option>
                      @foreach($status as $key => $value)
                          <option value="{{$key}}"  {{ $key == old("status") }} >{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="invoices-table_length">{{ __('Limit') }}</label>
                    <select name="invoices-table_length" id="invoices-table_length" aria-controls="invoices-table" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                  </div>
                </div>
                <div class="table table-striped table-sm">
                  <table class="table" id="invoices-table">
                    <thead class=" text-primary">
                    <tr>
                      <th>
                          {{ __('Code') }}
                      </th>
                      @if (!empty($customers))
                      <th>
                          {{ __('Customer') }}
                      </th>
                      @endif
                      <th>
                          {{ __('Date') }}
                      </th>
                      <th>
                          {{ __('Due Date') }}
                      </th>
                      <th>
                          {{ __('Total') }}
                      </th>
                      <th class="status">
                          {{ __('Status') }}
                      </th>
                      <th>
                        {{ __('Actions') }}
                      </th>
                    </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="modalInvoice" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg h-100" role="document">
          <div class="modal-content" style="height:95%">
              <div class="modal-header">
                  <h5 class="modal-title">{{ __('Invoice') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body h-100"><iframe src="" frameborder="0" style="width: 100%;height: 100%;position: relative;" ></iframe></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="print">{!! __('<i class="material-icons">print</i> Print') !!}</button>
                <a href="" class="btn btn-primary" id="billet">{!! __('<i class="material-icons">attach_money</i> Billet') !!}</a>
                <a href="" class="btn btn-primary" id="download-csv">{!! __('<i class="material-icons">cloud_download</i> Download CSV') !!}</a>
                <button type="button" class="btn" data-dismiss="modal">{{ __('Close') }}</button>
              </div>
          </div>
      </div>
  </div>
@endsection
@push('js')
    <script>

        function filterStatus(status) {
            var color = 'default'

            switch (status) {
                case '{{__('__OVERDUE__')}}':
                    color = 'danger';
                    break;
                case '{{__('__OPENED__')}}':
                    color = 'warning';
                    break;
                case '{{__('__PAID__')}}':
                    color = 'success';
                    break;
                default:
                    'default';
            }

            return "<span class='badge badge-" + color + "'>" + status + "</span>";
        }

        $(document).ready(function() {
            $('#print').on('click', function() {
                $('.modal-body iframe').contents().find('body').append('<script>window.print()</sc'+'ript>')
            });

            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    console.log(data)
                    var min = parseInt( $('#min').val(), 10 );
                    var max = parseInt( $('#max').val(), 10 );
                    var age = parseFloat( data[3] ) || 0; // use data for the age column
            
                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && age <= max ) ||
                        ( min <= age   && isNaN( max ) ) ||
                        ( min <= age   && age <= max ) )
                    {
                        return true;
                    }
                    return false;
                }
            );
            $('#min, #max').keyup( function() {
                table.draw();
            } );

            table = $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: {{ env('DEFAULT_PAGE_LENGTH') }},
                ajax: '{{ route('api_invoice.index') }}',
                orderCellsTop: true,
                order: [[2, 'desc']],
                fixedHeader: true,
                sDom: '<"top">tr<"bottom"ip><"clear">',
                columns: [
                    {data: 'invoice_code', name: 'invoice_code'},
                    @if (!empty($customers))
                    {data: 'client', name: 'client'},
                    @endif
                    {data: 'date', name: 'date'},
                    {data: 'duedate', name: 'duedate'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "columnDefs": [
                    {
                        "render": function (data, type, row) {
                            return filterStatus(data);
                        },
                        "targets": 'status'
                    },
                ],
                initComplete: function () {
                    $('#customer').on( 'keyup change', function () {
                        table
                            .column('client:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#status').on( 'keyup change', function () {
                        table
                            .column('status:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#from-date,#to-date').on( 'keyup change', function () {
                        table
                            .column('date:name')
                            .search( $('#from-date').val()+'|'+$('#to-date').val() )
                            .draw();
                    });
                    $('#from-duedate,#to-duedate').on( 'keyup change', function () {
                        table
                            .column('duedate:name')
                            .search( $('#from-duedate').val()+'|'+$('#to-duedate').val() )
                            .draw();
                    });
                    $('#invoices-table_length').on( 'keyup change', function () {
                        table.page.len( this.value ).draw();
                    });
                }
            });

            $('#modalInvoice').on('show.bs.modal', function (e) {
                var button = $(e.relatedTarget);
                var modal = $(this);
                modal.find('iframe').attr('src',button.data('remote'));
                $('#download-csv').show().attr('href',button.data('csv'))
                if (button.data('billet')) {
                    $('#billet').show().attr('href',button.data('billet'))
                } else {
                    $('#billet').hide()
                }
            });
        });
    </script>
    <style>
        table#invoices-table {
            width: 100%;
        }
        .modal-full {
            min-width: 100%;
            margin: 0;
        }

        .modal-full .modal-content {
            min-height: 100vh;
        }
        .badge-default {
            color: #ffffff;
            background-color: #000000;
        }
    </style>
@endpush
