@extends('layouts.app', ['activePage' => 'customer-management', 'titlePage' => __('Customer Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route( ($customer->typeable_type == \App\User::class)? 'customer.user.update' : 'customer.update', $customer) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit customer') }}</h4>
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
                              <input class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="input-code" type="text" placeholder="{{ __('Code') }}" value="{{ old('code', $customer->code) }}" required="true" aria-required="true" readonly="readonly"/>
                              @if ($errors->has('code'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('code') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  @if($customer->typeable_type == \App\User::class)
                      @include('customers.forms.user', compact('customer'))
                  @else
                      @include('customers.forms.company', compact('customer'))
                  @endif
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Phone Number') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('Phone') }}" value="{{ old('phone', $customer->typeable->phone) }}" aria-required="true" />
                              @if ($errors->has('phone'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('phone') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('Address') }}" value="{{ old('address', $customer->typeable->address) }}" aria-required="true" />
                              @if ($errors->has('address'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('address') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
