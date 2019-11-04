<div class="row">
    <label class="col-sm-2 col-form-label">{{ __('CPF') }}</label>
    <div class="col-sm-7">
        <div class="form-group{{ $errors->has('cpf') ? ' has-danger' : '' }}">
            <input class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" id="input-cpf" type="text" placeholder="{{ __('CPF') }}" value="{{ old('cpf', $customer->cnpj_cpf ?: $customer->typeable->cpf ) }}" required="true" aria-required="true"/>
            @if ($errors->has('cpf'))
                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('cpf') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
    <div class="col-sm-7">
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('name') }}" value="{{ old('name', trim($customer->firstname . ' ' . $customer->lastname)?: $customer->typeable->name ) }}" required />
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
            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', isset($customer->typeable) ? $customer->typeable->email : '' )}}" required />
            @if ($errors->has('email'))
                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label" for="input-password">{{ __(' Password') }}</label>
    <div class="col-sm-7">
        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="text" name="password" id="input-password" placeholder="{{ __('Password') }}" value="" @if(!isset($customer->typeable)) required @endif />
            @if ($errors->has('password'))
                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>
</div>
