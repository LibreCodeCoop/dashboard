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
                <div class="table table-striped table-sm">
                  <table class="table" id="call-table">
                    <thead class=" text-primary">
                    <tr>
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
                    </tr>
                    </thead>
                      <tfoot>
                      <tr>
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
  <div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Player') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p class="align-content-center">
                      <audio id="call-player"class="" src="" controls></audio>
                  </p>
              </div>
              <div class="modal-footer">
              </div>
          </div>
      </div>
  </div>
@endsection
@push('js')
    <script>
        function showPlayerModal(link){
            player = document.getElementById('call-player');
            player.src = $(link).attr('data-url');
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
                columns: [
                    {data: 'cliente', name: 'cliente'},
                    {data: 'start_time', name: 'start_time'},
                    {data: 'duration', name: 'duration'},
                    {data: 'origin_number', name: 'origin_number'},
                    {data: 'destination_number', name: 'destination_number'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                initComplete: function () {
                $('#call-table thead tr').clone().appendTo( '#call-table thead' );
                $('#call-table thead tr:eq(1) th').each( function (i) {
                    if( i == 5) {
                        $(this).html( '<span />' );
                        return;
                    }

                    if( i == 0) {
                        var select = $(document.createElement("select"));
                        select.addClass("custom-select custom-select-sm form-control form-control-sm");
                        select.append($('<option>').val('').text('{{ __('All') }}'));
                        $.get('{{ route("api_usercustomers.index", ['user' => $userId]) }}', function (data) {

                            if(data.length === 1) {
                                $('#call-table thead tr:eq(1) th:first').css('display', 'none');
                                table.column(0).visible(false);
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



            $('#playerModal').on('hide.bs.modal', function (event) {
                player = document.getElementById('call-player');
                player.pause();
                player.currentTime = 0;
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
        table#call-table {
            width: 100%;
        }
    </style>
@endpush
