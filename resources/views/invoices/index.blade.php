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
                <div class="table table-striped table-sm">
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
  <div class="modal" id="modalInvoice" tabindex="-1" role="dialog">
      <div class="modal-dialog  modal-full" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">{{ __('Invoice') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer">
                  <button type="button" class="btn" data-dismiss="modal">{{ __('Fechar') }}</button>
              </div>
          </div>
      </div>
  </div>
  <iframe id="iprint" name="iprint" scrolling="yes" style="display:none"></iframe>
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

        function printInvoice(e, anchor){
            var win = window.open(anchor, '_blank');
            win.focus();
            e.preventDefault();
            return false;
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
                    $('#invoices-table thead tr:eq(1) th').each( function (i) {
                        if( i === 6) {
                            $(this).html( '<span />' );
                            return;
                        } else if( i === 5 ) {
                            var selectStatus = $(document.createElement("select"));
                            selectStatus.addClass("custom-select custom-select-sm form-control form-control-sm");
                            selectStatus.append($('<option>').val('').text('{{ __('All') }}'));
                            ['Em atraso', 'Em aberto', 'Pago', 'Cancelada'].forEach(function (e) {
                                selectStatus.append($('<option>', {
                                    value: e,
                                    text: e
                                }))
                            });

                            selectStatus.on( 'keyup change', function () {
                                if ( table.column(i).search() !== this.value ) {
                                    table
                                        .column(i)
                                        .search( this.value )
                                        .draw();
                                }
                            });
                            $(this).html(selectStatus).addClass('hide-sort');
                            return;
                        } else if (i === 1) {

                            var select = $(document.createElement("select"));
                            select.addClass("custom-select custom-select-sm form-control form-control-sm");
                            select.append($('<option>').val('').text('{{ __('All') }}'));
                            $.get('{{ route("api_usercustomers.index", ['user' => $userId]) }}', function (data) {

                                if(data.length === 1) {
                                    $('#invoices-table thead tr:eq(1) th:eq(1)').css('display', 'none');
                                    table.column(1).visible(false);
                                    return;
                                }

                                data.forEach(function (e) {
                                    select.append($('<option>',{
                                        text: e.name,
                                        value: e.name

                                    }))
                                })

                                select.on( 'keyup change', function () {
                                    if ( table.column(i).search() !== this.value ) {
                                        table
                                            .column(i)
                                            .search( this.value )
                                            .draw();
                                    }
                                });
                            })

                            $(this).html(select).addClass('hide-sort');
                            return;
                        }

                        var title = $(this).text();
                        $(this).html( '<input type="text" />' );

                        $( 'input', this ).on( 'keyup change', function () {
                            if ( table.column(i).search() !== this.value ) {
                                table
                                    .column(i)
                                    .search( this.value )
                                    .draw();
                            }
                        } );

                    });
                }
            });

            $('#modalInvoice').on('show.bs.modal', function (e) {
                var button = $(e.relatedTarget);
                var modal = $(this);
                modal.find('.modal-body').load(button.data("remote"));
            });
        });
    </script>
    <style>
        .dataTables_filter {
            display: none;
        }
        thead input {
            width: 100%;
        }
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
