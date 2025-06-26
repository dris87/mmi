@extends('layouts.auth')
@section('title')
    {{ __('web.common.change_password') }}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Új jelszó megadása</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('backoffice.user.password.update', ['token' => $token]) }}">
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
                           name="email" tabindex="1" value="{{ $userModel->getEmail() }}" disabled>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password" class="control-label">{{ __('web.common.password') }}</label>
                    <input autocomplete="new-password"
                           id="new_password"
                           type="password"
                           name="new_password"
                           class="form-control{{ $errors->has('new_password') ? ' is-invalid': '' }}"
                           tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation" class="control-label">{{ __('web.common.confirm_password') }}</label>
                    <input autocomplete="new-password" id="new_password_confirmation" type="password"
                           class="form-control{{ $errors->has('new_password_confirmation') ? ' is-invalid': '' }}"
                           name="new_password_confirmation" tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password_confirmation') }}
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
    @push('scripts')
        {!! JsValidator::formRequest('App\Http\Requests\PasswordUpdateRequest') !!}
    @endpush
@endsection
