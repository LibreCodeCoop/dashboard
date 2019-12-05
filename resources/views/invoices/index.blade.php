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
                    <tr>
                    <th>
                        {{ __('Code') }}
                    </th>                    <th>
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
                        {{ __('Status') }}
                    </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </tr>
                    </thead>
                      <tfoot class=" text-primary">
                      <th>
                          {{ __('Code') }}
                      </th>
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
        $(document).ready(function() {

            var table = $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api_invoice.index') }}',
                orderCellsTop: true,
                fixedHeader: true,
                columns: [
                    {data: 'invoice_code', name: 'invoice_code'},
                    {data: 'client', name: 'client'},
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
                        "targets": 5
                    },
                ],
                initComplete: function () {
                    $('#invoices-table thead tr').clone().appendTo('#invoices-table thead');
                    this.api().columns().every(function (index) {
                        var column = this;

                        if (index === 6) {
                            $(document.createElement("span")).appendTo($(column.header()).empty())
                            return;
                        } else if (index === 5) {
                            var select = $(document.createElement("select"));
                            select.addClass("custom-select custom-select-sm form-control form-control-sm");
                            ['', 'Em atraso', 'Em aberto', 'Pago', 'Cancelada'].forEach(function (e) {
                                select.append($('<option>', {
                                    value: e,
                                    text: e
                                }))
                            })
                            select.appendTo($(column.header()).empty())
                            select.on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        } else if (index === 1) {

                            var select = $(document.createElement("select"));
                            select.addClass("custom-select custom-select-sm form-control form-control-sm");
                            select.append($('<option>'))
                            $.get('{{ route("api_customer.index") }}', function (data) {
                                data.forEach(function (e) {
                                    select.append($('<option>', {
                                        // value: e.id,
                                        text: (e.typeable_type == 'App\\User') ? e.typeable.name : e.typeable.social_reason,
                                        value: (e.typeable_type == 'App\\User') ? e.typeable.name : e.typeable.social_reason

                                    }))
                                })
                            })
                            select.appendTo($(column.header()).empty())
                            select.on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        } else {

                            var input = document.createElement("input");
                            $(input).appendTo($(column.header()).empty())
                                .on('keyup change clear', function () {
                                    if (column.search() !== this.value) {
                                        column
                                            .search(this.value)
                                            .draw();
                                    }
                                });
                        }
                    });
                }
            });
        });
    </script>
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush
