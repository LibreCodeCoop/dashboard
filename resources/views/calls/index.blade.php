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
                  <table class="table">
                    <thead class=" text-primary">
                    <th>
                        {{ __('Id') }}
                    </th>
                    <th>
                        {{ __('Customer Code') }}
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
                    <tbody>
                      @foreach($calls as $call)
                        <tr>
                            <td>
                                {{ $call->id }}
                            </td>
                            <td>
                                {{ $call->customer->code }}
                            </td>
                            <td>
                                {{ $call->start->format('Y-m-d H:i:s') }}
                            </td>
                          <td>
                            {{ $call->duration }} min
                          </td>
                          <td>
                            {{ $call->source_phone }}
                          </td>
                          <td>
                            {{ $call->destination_phone }}
                          </td>
                          <td class="td-actions text-right">
                           <button type="button" class="btn btn-link" data-original-title="" title="" onclick="showPlayerModal({{ $call->id }})">
                            <i class="material-icons">play_circle_outline</i>
                            <div class="ripple-container"></div>
                           </button>
                          <button type="button" class="btn btn-link" data-original-title="" title="" onclick="alert('{{ __("Download Call is an test, Nothing will happen") }}') ">
                              <i class="material-icons">cloud_download</i>
                              <div class="ripple-container"></div>
                          </button>

                              <!-- Modal -->
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
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{ $calls->links() }}
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


            $('#playerModal').on('hide.bs.modal', function (event) {
                player = document.getElementById('call-player');
                player.pause();
                player.currentTime = 0;
            });
        });
    </script>
@endpush
