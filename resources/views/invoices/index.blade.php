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
                  <table class="table" id="invoices-table">
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
                      <tfoot class=" text-primary">
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
                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
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
                case 'Em atraso':
                    color = 'danger';
                    break;
                case 'Em aberto':
                    color = 'warning';
                    break;
                case 'Pago':
                    color = 'success';
                    break;
                default:
                    'default';
            }

            return "<span class='badge badge-" + color + "'>" + status + "</span>";
        }

        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api_invoice.index') }}',
            columns: [
                {data: 'client', name: 'client'},
                {data: 'date', name: 'date'},
                {data: 'duedate', name: 'duedate'},
                {data: 'total', name: 'total'},
                {data: 'code', name: 'code'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "columnDefs": [
                {
                    "render": function ( data, type, row ) {
                        return filterStatus(data);
                    },
                    "targets": 5
                },
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    if(index === 6) return;

                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
            }
        });
    </script>
@endpush
