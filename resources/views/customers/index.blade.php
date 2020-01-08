@extends('layouts.app', ['activePage' => 'customer-management', 'titlePage' => __('Customers Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Customers') }}</h4>
                <p class="card-category"> {{ __('Here you can manage customers') }}</p>
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
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary">{{ __('Add customer') }}</a>
                  </div>
                </div>
                <div class="table table-striped table-sm">
                  <table class="table" id="customer-table">
                    <tfooter class=" text-primary">
                    <tr>
                        <th>
                            {{ __('Code') }}
                        </th>
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Document') }}
                      </th>
                      <th>
                        {{ __('Creation date') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </tr>
                    </tfooter>
                      <thead class=" text-primary">
                      <tr>
                          <th>
                              {{ __('Code') }}
                          </th>
                          <th>
                              {{ __('Name') }}
                          </th>
                          <th>
                              {{ __('Document') }}
                          </th>
                          <th>
                              {{ __('Creation date') }}
                          </th>
                          <th class="text-right">
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
@endsection
@push('js')
    <script>
        function submitExcludeUser(userForm){
            $('input[name=_token]', userForm).val($('meta[name="csrf-token"]').attr('content'));
            userForm.submit();
        }

        $(document).ready(function() {

            var table = $('#customer-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: {{ env('DEFAULT_PAGE_LENGTH') }},
                ajax: '{{ route('api_customer.index') }}',
                orderCellsTop: true,
                columns: [
                    {data: 'code', name: 'code', width: '20%'},
                    {data: 'name', name: 'name', width: '45%'},
                    {data: 'document', name: 'document', width: '20%'},
                    {data: 'created_at', name: 'created_at', width: '20%'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, width: '5%'}
                ],
                initComplete: function () {
                    $('#customer-table thead tr').clone().appendTo( '#customer-table thead' );
                    $('#customer-table thead tr:eq(1) th').each( function (i) {

                        if( i >= 4) {
                            $(this).html( '<span />' );
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
                        });
                    });
                }
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
        table#customer-table {
            width: 100%;
        }
        .user-form a,
        .user-form button{
            padding: 0;
        }
    </style>
@endpush

