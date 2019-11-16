<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
        <img src="{{ asset("img/logo.png") }}" style="width: 100%">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
        <li class="nav-item{{ $activePage == 'customer-management' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('customer.index') }}">
                <i class="material-icons">content_paste</i>
                <p>{{ __('Customer Management') }}</p>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="material-icons">content_paste</i>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'call-history' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('call.index') }}">
                <i class="material-icons">content_paste</i>
                <span class="sidebar-normal"> {{ __('Call History') }} </span>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'invoice-listing' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('invoice.index') }}">
                <i class="material-icons">content_paste</i>
                <span class="sidebar-normal"> {{ __('Invoice Listing') }} </span>
            </a>
        </li>
    </ul>
  </div>
</div>
