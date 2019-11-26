@extends('layouts.app', ['activePage' => 'call-history', 'titlePage' => __('Calls Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Calls') }}</h4>
                <p class="card-category"> {{ __('Here you can manage calls') }}</p>
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
                  <table class="table" id="call-table">
                    <thead class=" text-primary">
                    <th>
                        {{ __('Customer') }}
                    </th>
                    <th>
                        {{ __('Start Time') }}
                    </th>
                    <th>
                        {{ __('Duration') }}
                    </th>
                        <th>
                            {{ __('Source Phone') }}
                        </th>
                      <th>
                          {{ __('Destination Phone') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                      <tfoot>
                      <th>
                          {{ __('Customer') }}
                      </th>
                      <th>
                          {{ __('Start Time') }}
                      </th>
                      <th>
                          {{ __('Duration') }}
                      </th>
                      <th>
                          {{ __('Source Phone') }}
                      </th>
                      <th>
                          {{ __('Destination Phone') }}
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
        function showPlayerModal(id){
            player = document.getElementById('call-player');

            urlRaw = '{{ route('call.audio') }}/?file=' + id;

            player.src = urlRaw;
            console.log(player.src)
            player.currentTime = 0;
            $('#playerModal').modal()
            player.play();
        }

        $(document).ready(function() {

            var table = $('#call-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api_call.index') }}',
                orderCellsTop: true,
                fixedHeader: true,
                columns: [
                    {data: 'cliente', name: 'cliente'},
                    {data: 'start_time', name: 'start_time'},
                    {data: 'duration', name: 'duration'},
                    {data: 'origin_number', name: 'origin_number'},
                    {data: 'destination_number', name: 'destination_number'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });



            $('#playerModal').on('hide.bs.modal', function (event) {
                player = document.getElementById('call-player');
                player.pause();
                player.currentTime = 0;
            });
        });
    </script>
@endpush
