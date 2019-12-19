<div class="row">
    <label class="col-sm-2 col-form-label">{{ __('CNPJ') }}</label>
    <div class="col-sm-7">
        <div class="form-group{{ $errors->has('cnpj') ? ' has-danger' : '' }}">
            <input class="form-control{{ $errors->has('cnpj') ? ' is-invalid' : '' }}" name="cnpj" id="input-cnpj" type="text" placeholder="{{ __('CNPJ') }}" value="{{ old('cnpj', $customer->cnpj_cpf ?? $customer->typeable->cnpj ) }}" required="true" aria-required="true"/>
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
            <input class="form-control{{ $errors->has('social_reason') ? ' is-invalid' : '' }}" name="social_reason" id="input-social_reason" type="text" placeholder="{{ __('social_reason') }}" value="{{ old('social_reason', $customer->social_reason ?? $customer->typeable->social_reason )}}" required />
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
            <input class="form-control{{ $errors->has('municipal_registration') ? ' is-invalid' : '' }}" name="municipal_registration" id="input-municipal_registration" type="text" placeholder="{{ __('municipal_registration') }}" value="{{ old('municipal_registration', $customer->municipal_registration ?? $customer->typeable->municipal_registration ) }}" />
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
            <input class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="input-state" type="text" placeholder="{{ __('state') }}" value="{{ old('state', $customer->state ?? $customer->typeable->state ) }}" />
            @if ($errors->has('state'))
                <span id="state-error" class="error text-danger" for="input-state">{{ $errors->first('state') }}</span>
            @endif
        </div>
    </div>
</div>
