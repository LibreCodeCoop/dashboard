@extends('layouts.app', ['activePage' => 'call-history', 'titlePage' => __('Calls Management')])

@section('content')
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
    #domainsContainer {
      display: none;
    }
  </style>
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
                  <div class="col-md-auto" id="domainsContainer">
                    <label class="mdb-main-label" for="domains">{{ __('Domains') }}</label>
                    <select id="domains" class="form-control custom-select" name="domains">
                      <option value="" selected>{{ __('All') }}</option>
                    </select>
                  </div>
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="source">{{ __('Source Phone') }}</label>
                    <input id="source" class="form-control" name="source" placeholder="{{ __('Source Phone') }}">
                  </div>
                  <div class="col-md-auto">
                    <label class="mdb-main-label" for="destination">{{ __('Destination Phone') }}</label>
                    <input id="destination" class="form-control" name="destination" placeholder="{{ __('Destination Phone') }}">
                  </div>
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
                    <label class="mdb-main-label" for="invoices-table_length">{{ __('Limit') }}</label>
                    <select name="invoices-table_length" id="invoices-table_length" aria-controls="invoices-table" class="custom-select custom-select-sm form-control form-control-sm">
                      @for($i = 10; $i <= 100; $i+=10)
                        <option value="{{ $i }}"
                          @if($i < env('DEFAULT_PAGE_LENGTH') && $i+10 >= env('DEFAULT_PAGE_LENGTH') )
                            selected="selected"
                          @endif>
                          {{ $i }}
                        </option>
                      @endfor
                    </select>
                  </div>
                </div>
                <div class="table table-striped table-sm">
                  <table class="table" id="call-table">
                    <thead class=" text-primary">
                    <tr>
                    @if (!empty($customers))
                    <th>
                        {{ __('Customer') }}
                    </th>
                    @endif
                    <th>
                        {{ __('Domain') }}
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
  <iframe id="downloadIFrame" src="" style="display:none; visibility:hidden;"></iframe>
@endsection
@push('js')
    <script>
        function showPlayerModal(id){
            player = document.getElementById('call-player');

            urlRaw = '{{ route('call.audio') }}/?uuid=' + id;

            player.src = urlRaw;
            player.currentTime = 0;
            $('#playerModal').modal()
            player.play();
        }
        function downloadAudio(id){
            urlRaw = '{{ route('call.audio.download') }}/?uuid=' + id;
            $("#downloadIFrame").attr("src",urlRaw);
        }

        $(document).ready(function() {

            var table = $('#call-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: {{ env('DEFAULT_PAGE_LENGTH') }},
                ajax: {
                    url: '{{ route('api_call.index') }}',
                    dataFilter: function(data) {
                        var column = table.column('domain:name');
                        var json = jQuery.parseJSON( data );
                        if (typeof json.dataDomains !== 'undefined' && json.dataDomains.length > 1) {
                            var selected = $('#domains').val();
                            column.visible(true);
                            $('#domainsContainer').show(1000);
                            $('#domains')
                                .find('option')
                                .remove()
                                .end()
                                .append($('<option value=""">{{ __('All') }}</option>'));
                            $.each(json.dataDomains, function (i, item) {
                                $('#domains').append($('<option>', { 
                                    value: item.domain,
                                    text : item.domain,
                                    selected: selected == item.domain
                                }));
                            });
                        } else {
                          column.visible(false);
                          $('#domainsContainer').hide(1000);
                        }
                        return JSON.stringify( json );
                    }
                },
                sDom: '<"top">tr<"bottom"ip><"clear">',
                // orderCellsTop: true,
                // order: [[1, 'desc']],
                ordering: false,
                columns: [
                    @if (!empty($customers))
                    {data: 'client', name: 'client'},
                    @endif
                    {data: 'domain', name: 'domain', visible: false },
                    {data: 'start_time', name: 'start_time'},
                    {data: 'duration', name: 'duration'},
                    {data: 'origin_number', name: 'origin_number'},
                    {data: 'destination_number', name: 'destination_number'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                initComplete: function () {
                    $('#customer').on( 'keyup change', function () {
                        table
                            .column('client:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#domains').on( 'keyup change', function () {
                        table
                            .column('domain:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#source').on( 'keyup change', function () {
                        table
                            .column('origin_number:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#destination').on( 'keyup change', function () {
                        table
                            .column('destination_number:name')
                            .search( this.value )
                            .draw();
                    });
                    $('#from-date,#to-date').on( 'keyup change', function () {
                        table
                            .column('start_time:name')
                            .search( $('#from-date').val()+'|'+$('#to-date').val() )
                            .draw();
                    });
                    $('#invoices-table_length').on( 'keyup change', function () {
                        table.page.len( this.value ).draw();
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
@endpush
