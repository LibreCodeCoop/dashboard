@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Users') }}</h4>
                <p class="card-category"> {{ __('Here you can manage users') }}</p>
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
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table" id="user-table">
                    <thead class=" text-primary">
                        <tr>
                          <th>
                              {{ __('Name') }}
                          </th>
                          <th>
                            {{ __('Email') }}
                          </th>
                          <th>
                              {{ __('Customers') }}
                          </th>
                          <th>
                            {{ __('Creation date') }}
                          </th>
                          <th class="text-right">
                            {{ __('Actions') }}
                          </th>
                        </tr>
                    </thead>
                      <tfoot class=" text-primary">
                      <tr>
                          <th>
                              {{ __('Name') }}
                          </th>
                          <th>
                              {{ __('Email') }}
                          </th>
                          <th>
                              {{ __('Customers') }}
                          </th>
                          <th>
                              {{ __('Creation date') }}
                          </th>
                          <th class="text-right">
                              {{ __('Actions') }}
                          </th>
                      </tr>
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
        function submitExcludeUser(userForm){
            $('input[name=_token]', userForm).val($('meta[name="csrf-token"]').attr('content'));
            userForm.submit();
        }

        $(document).ready(function() {

            var table = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api_user.index') }}',
                orderCellsTop: true,
                columns: [
                    {data: 'name', name: 'name', width: '20%'},
                    {data: 'email', name: 'email', width: '20%'},
                    {data: 'created_at', name: 'created_at', width: '10%'},
                    {data: 'customers', name: 'customers', width: '45%'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, width: '5%'}
                ],
                initComplete: function () {
                    $('#user-table thead tr').clone().appendTo( '#user-table thead' );
                    $('#user-table thead tr:eq(1) th').each( function (i) {

                        if( i >= 3) {
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
        table#user-table {
            width: 100%;
        }
        .user-form a,
        .user-form button{
            padding: 0;
        }
    </style>
@endpush
