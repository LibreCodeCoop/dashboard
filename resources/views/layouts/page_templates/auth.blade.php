<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footers.auth')
  </div>
</div>
@push('load_js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ Auth::user()->api_token }}",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endpush
