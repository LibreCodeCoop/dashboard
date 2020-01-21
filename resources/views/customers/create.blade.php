@extends('layouts.app', ['activePage' => 'customer-management', 'titlePage' => __('Customers Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route($routerStore) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add Customer') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="input-code" type="text" placeholder="{{ __('Code') }}" value="{{ old('code', $customer->code) }}" required="true" aria-required="true" readonly/>
                              @if ($errors->has('code'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('code') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  @if($isUser)
                      @include('customers.forms.user', compact('customer'))
                  @else
                      @include('customers.forms.company', compact('customer'))
                  @endif
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('phone') }}" value="{{ old('phone', $customer->phone) }}" />
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
                              <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('Address') }}" value="{{ old('address', $customer->address) }}" />
                              @if ($errors->has('address'))
                                  <span id="address-error" class="error text-danger" for="input-address">{{ $errors->first('address') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Listen records') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('listen_records') ? ' has-danger' : '' }} pull-left">
                              <input class="{{ $errors->has('listen_records') ? ' is-invalid' : '' }}" name="listen_records" id="input-listen_records" type="checkbox" placeholder="{{ __('Listen records') }}" value="1" {{ old('listen_records', $customer->listen_records?'checked':'') }} />
                              @if ($errors->has('listen_records'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('listen_records') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Add Customer') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
