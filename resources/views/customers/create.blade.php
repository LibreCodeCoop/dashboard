@extends('layouts.app', ['activePage' => 'customer-management', 'titlePage' => __('Customers Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('customer.store') }}" autocomplete="off" class="form-horizontal">
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
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('CNPJ') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('cnpj') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('cnpj') ? ' is-invalid' : '' }}" name="cnpj" id="input-cnpj" type="text" placeholder="{{ __('CNPJ') }}" value="{{ old('cnpj', $customer->cnpj_cpf) }}" required="true" aria-required="true" readonly/>
                              @if ($errors->has('cnpj'))
                                  <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('cnpj') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Social Reason') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('social_reason') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('social_reason') ? ' is-invalid' : '' }}" name="social_reason" id="input-social_reason" type="text" placeholder="{{ __('social_reason') }}" value="{{ old('social_reason', $customer->social_reason) }}" required />
                              @if ($errors->has('social_reason'))
                                  <span id="social_reason-error" class="error text-danger" for="input-social_reason">{{ $errors->first('social_reason') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Municipal Registration') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('municipal_registration') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('municipal_registration') ? ' is-invalid' : '' }}" name="municipal_registration" id="input-municipal_registration" type="text" placeholder="{{ __('municipal_registration') }}" value="{{ old('municipal_registration', $customer->municipal_registration) }}" required />
                              @if ($errors->has('municipal_registration'))
                                  <span id="municipal_registration-error" class="error text-danger" for="input-municipal_registration">{{ $errors->first('municipal_registration') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('State Registation') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="input-state" type="text" placeholder="{{ __('state') }}" value="{{ old('state', $customer->state) }}" required />
                              @if ($errors->has('state'))
                                  <span id="state-error" class="error text-danger" for="input-state">{{ $errors->first('state') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <label class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                      <div class="col-sm-7">
                          <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('phone') }}" value="{{ old('phone', $customer->phone) }}" required />
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
                              <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address" type="text" placeholder="{{ __('Address') }}" value="{{ old('address', $customer->address) }}" required />
                              @if ($errors->has('address'))
                                  <span id="address-error" class="error text-danger" for="input-address">{{ $errors->first('address') }}</span>
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
