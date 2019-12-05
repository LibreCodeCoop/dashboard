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
{{--                          <th>--}}
{{--                              {{ __('Customers') }}--}}
{{--                          </th>--}}
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
{{--                          <th>--}}
{{--                              {{ __('Customers') }}--}}
{{--                          </th>--}}
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

        $(document).ready(function() {

            var table = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api_user.index') }}',
                orderCellsTop: true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    // {data: 'customers', name: 'customers'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });
        });
    </script>
@endpush
