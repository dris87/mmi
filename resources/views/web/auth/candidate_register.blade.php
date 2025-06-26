@extends('web.layouts.app')
@section('title')
    {{ __('web.register') }}
@endsection
@section('content')

    <div class="login-section">
        <div class="image-layer" style="background-image: url({{asset('web_front/images/background/login.jpeg')}});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form">
                <div class="form-inner">
                    <h3>{{__('messages.notification_settings.candidate').' '.__('web.register') }}</h3>

                    <!--Login Form-->
                    {{ Form::open(['id'=>'addCandidateNewForm']) }}
                    <div class="form-group">
                        <div class="btn-box row">
                            <div class="col-lg-6 col-md-12">
                                <a href="{{route('candidate.register')}}" class="theme-btn btn-style-seven"><i class="la la-user"></i> Munkavállaló </a>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <a href="{{ route('front.page.employer_register') }}" class="theme-btn btn-style-four"><i class="la la-briefcase"></i> Munkáltató
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <input type="hidden" name="type" value="1">
                            <div class="form-group col-md-6">
                                <label>{{ __('web.common.first_name').":" }}
                                    <span class="required asterisk-size">*</span> </label>
                                <input type="text" name="first_name" id="candidateFirstName" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('web.common.last_name').":" }}</label>
                                <input type="text" name="last_name" id="candidateLastName" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __('web.common.email').":" }}
                                    <span class="required asterisk-size">*</span></label>
                                <input type="email" autocomplete="new-password" name="email" id="candidateEmail" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('web.common.password').":" }}
                                    <span class="required asterisk-size">*</span></label>
                                <input type="password" autocomplete="new-password" name="password" id="candidatePassword" class="form-control" required onkeypress="return avoidSpace(event)">
                            </div>
                        <div class="form-group col-md-6">
                            <label>{{ __('web.common.confirm_password').":" }}
                                <span class="required asterisk-size">*</span></label>
                            <input type="password" name="password_confirmation" id="candidateConfirmPassword"
                                   class="form-control" required onkeypress="return avoidSpace(event)">
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="privacyPolicy" id="exampleCheck1">
                        <label class="form-check-label"
                               for="exampleCheck1">{{__('messages.company.i_accept')}}
                            <a href="{{ route('terms.conditions.list') }}"
                               target="_blank">{{__('messages.company.terms')}}</a>
                            {{__('messages.company.and_the')}}
                            <a href="{{ route('privacy.policy.list') }}"
                               target="_blank">{{__('messages.company.privacy_policy')}}</a>.
                        </label>

                    </div>
                    @if($isGoogleReCaptchaEnabled)
                        <div class="form-group mt10">
                            <div class="g-recaptcha d-flex justify-content-center"
                                 data-sitekey="{{ config('app.google_recaptcha_site_key') }}"></div>
                            <div id="g-recaptcha-error"></div>
                        </div>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="theme-btn btn-style-one" id="btnCandidateSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')>
                                    {{ __('web.register_menu.create_account') }}
                                </button>
                    </div>
                    {{ Form::close() }}
{{--                    <div class="bottom-box">--}}
{{--                        <div class="divider"><span>or</span></div>--}}
{{--                        <div class="btn-box row">--}}
{{--                            <div class="col-lg-6 col-md-12">--}}
{{--                                <a href="#" class="theme-btn social-btn-two facebook-btn"><i class="fab fa-facebook-f"></i>--}}
{{--                                    Log In via Facebook</a>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6 col-md-12">--}}
{{--                                <a href="#" class="theme-btn social-btn-two google-btn"><i class="fab fa-google"></i>--}}
{{--                                    Log In via Gmail</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
            <!--End Login Form -->
        </div>
    </div>
    <!-- ===== End of Login - Register Section ===== -->
@endsection

@if($isGoogleReCaptchaEnabled)
@section('page_scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@endif

@section('scripts')
    <script>
        let registerSaveUrl = "{{ route('front.save.register') }}";
        let candidateLogInUrl = "{{ route('front.candidate.login') }}";
        let isGoogleReCaptchaEnabled = "{{ (boolean)$isGoogleReCaptchaEnabled }}";
    </script>
    <script src="{{asset('assets/js/front_register/front_register.js?v=6.0.0')}}"></script>
    @if($isGoogleReCaptchaEnabled)
        <script src="{{asset('assets/js/front_register/google-recaptcha.js')}}"></script>
    @endif
@endsection
