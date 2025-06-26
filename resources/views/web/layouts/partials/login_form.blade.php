<!--Login Form-->
@include('flash::message')
<form method="POST" class="login-form" id="loginForm">
    @csrf
    <div id="candidateValidationErrBox">
        @include('layouts.errors')
    </div>
    <input type="hidden" name="type" value="{{ $isCandidate ?? 0 }}"/>
    <div class="form-group">
        <label>{{ __('web.common.email') }}</label>
        <input type="email" name="email" class="form-control" id="email"
               placeholder="{{ __('web.common.email') }}"
               value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}"
               autofocus required>
    </div>
    <div class="form-group">
        <label>{{ __('web.common.password') }}</label>
        <input type="password" name="password" class="form-control" id="password"
               placeholder="{{ __('web.common.password') }}"
               value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
               required>
    </div>
    <div class="form-group">
        <div class="field-outer">
            <div class="input-group checkboxes square">
                <input type="checkbox" name="remember" class="custom-control-input"
                       id="remember" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                <label for="remember">{{ __('web.login_menu.remember_me') }}</label>

            </div>
            <a href="{{ route('password.request') }}"
               class="pwd">{{ __('web.login_menu.forget_password') }}</a>
        </div>
    </div>
    <div class="form-group">
        <button id="submitBtn" class="submit-btn theme-btn btn-style-one">Bejelentkezés</button>
    </div>
</form>
