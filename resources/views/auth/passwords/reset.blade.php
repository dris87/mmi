@extends('layouts.auth')
@section('title')
    {{ __('web.common.change_password') }}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>{{ __('web.common.change_password') }}</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ url('/password/reset') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">{{ __('web.common.email') }}</label>
                    <input autocomplete="new-password" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">{{ __('web.common.password') }}</label>
                    <input autocomplete="new-password" id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="control-label">{{ __('web.common.confirm_password') }}</label>
                    <input autocomplete="new-password" id="password_confirmation" type="password"
                           class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                           name="password_confirmation" tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{ __('web.common.change_password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        {{ __('web.common.recalled_login_info') }} <a href="{{ route('login') }}">{{ __('web.login') }}</a>
    </div>
@endsection
