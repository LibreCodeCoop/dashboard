@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add User') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('CPF') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('cpf') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" id="input-cpf" type="text" placeholder="{{ __('CPF') }}" value="{{ old('cpf') }}"  aria-required="true" />
                              @if ($errors->has('cpf'))
                                  <span id="cpf-error" class="error text-danger" for="input-cpf">{{ $errors->first('cpf') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="phone" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}"/>
                              @if ($errors->has('phone'))
                                  <span id="phone-error" class="error text-danger" for="input-phone">{{ $errors->first('phone') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="address" placeholder="{{ __('Address') }}" value="{{ old('address') }}"/>
                              @if ($errors->has('address'))
                                  <span id="address-error" class="error text-danger" for="input-address">{{ $errors->first('address') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row" >
                      <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('customers') ? ' has-danger' : '' }}">
                              <select id="customers" multiple class="form-control{{ $errors->has('customers') ? ' is-invalid' : '' }} custom-select" name="customers[]" size="3" placeholder="{{ __('Customers') }}">
                                  @foreach($customers as $customer)
                                      <option value="{{$customer->id}}"  {{ in_array($customer->id, old("customers") ?: []) ? "selected": "" }} >{{ $customer->name }}</option>
                                  @endforeach
                              </select>
                              @if ($errors->has('customers'))
                                  <span id="customer-error" class="error text-danger" for="input-customer">{{ $errors->first('customers') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __(' Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" placeholder="{{ __('Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm Password') }}" value="" required />
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#customers').multiselect({
          maxHeight: 200,
          buttonWidth: '312px'
        });
    });
</script>
@endpush