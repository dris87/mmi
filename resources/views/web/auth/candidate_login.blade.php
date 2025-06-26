@extends('web.layouts.app')
@section('title')
    {{ __('web.login') }}
@endsection
@section('content')
{{--    <section class="page-header">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <h2>{{ __('web.login_menu.login_to') }} {{ __('web.register_menu.candidate') }}</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <section class="ptb80" id="login">--}}
{{--        <div class="container">--}}
{{--            <div class="col-md-6 col-md-offset-3 col-xs-12">--}}
{{--            @include('flash::message')--}}
{{--            <!-- Start of Tab Content -->--}}
{{--                <div class="tab-content">--}}
{{--                    <!-- Start of Tabpanel for Candidate Account -->--}}
{{--                    <div id="candidate">--}}
{{--                        <div class="login-box">--}}
{{--                            <form method="POST" action="{{ route('front.login') }}" id="candidateForm">--}}
{{--                                @csrf--}}
{{--                                <div id="candidateValidationErrBox">--}}
{{--                                    @include('layouts.errors')--}}
{{--                                </div>--}}
{{--                                <input type="hidden" name="type" value="1"/>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>{{ __('web.common.email') }}</label>--}}
{{--                                    <input type="email" name="email" class="form-control" id="email"--}}
{{--                                           placeholder="Your Email"--}}
{{--                                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}"--}}
{{--                                           autofocus required>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>{{ __('web.common.password') }}</label>--}}
{{--                                    <input type="password" name="password" class="form-control" id="password"--}}
{{--                                           placeholder="Your Password"--}}
{{--                                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"--}}
{{--                                           required>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-xs-6">--}}
{{--                                            <input type="checkbox" name="remember" class="custom-control-input"--}}
{{--                                                   id="remember" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>--}}
{{--                                            <label for="remember">{{ __('web.login_menu.remember_me') }}</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xs-6 text-right">--}}
{{--                                            <a href="{{ route('password.request') }}">{{ __('web.login_menu.forget_password') }}</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group text-center pb15">--}}
{{--                                    <button class="btn btn-purple btn-effect btn-login">{{ __('web.login') }}</button>--}}
{{--                                    <a href="{{ route('candidate.register') }}"--}}
{{--                                       class="btn btn-purple btn-effect btn-login">{{ __('web.sign_up') }}</a>--}}
{{--                                </div>--}}
{{--                                <div class="form-group text-center ml20">--}}
{{--                                    <div class="social-login-buttons d-flex flex-md-wrap justify-content-center">--}}
{{--                                        <a class="google-login btn-login" href="{{ url('/login/google?type=1') }}"><i--}}
{{--                                                    class="fa fa-google"></i>--}}
{{--                                            {{ __('web.login_menu.login_via_google') }}</a>--}}
{{--                                        <a class="facebook-login btn-login"--}}
{{--                                           href="{{ url('/login/facebook?type=1') }}"><i--}}
{{--                                                    class="fa fa-facebook"></i> {{ __('web.login_menu.login_via_facebook') }}--}}
{{--                                        </a>--}}
{{--                                        <a class="facebook-login btn-login"--}}
{{--                                           href="{{ url('/login/linkedin?type=1') }}"><i--}}
{{--                                                    class="fa fa-linkedin"></i> {{ __('web.login_menu.login_via_linkedin') }}--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- End of Tabpanel for Candidate Account -->--}}
{{--                </div>--}}
{{--                <!-- End of Tab Content -->--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{asset('web_front/images/background/login.jpeg')}});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form">
                <div class="form-inner" id="candidate">
                    <h3>{{ __('web.login_header.candidate_login') }}</h3>
                    <!--Login Form-->
                    @include('flash::message')
                    <div class="form-group">
                        <div class="btn-box row">
                            <div class="col-lg-6 col-md-12">
                                <a href="{{route('front.candidate.login')}}" class="theme-btn btn-style-seven"><i class="la la-user"></i>
                                    {{ __('web.common.candidate') }} </a>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <a href="{{ route('front.employee.login') }}" class="theme-btn btn-style-four "><i class="la la-briefcase"></i>
                                    {{ __('web.common.employer') }} </a>
                            </div>
                        </div>
                    </div>
                    @include('web.layouts.partials.login_form',['isCandidate' => 1])
{{--                    <div class="bottom-box">--}}
{{--                        <div class="text">Nincs még fiókja? <a--}}
{{--                                    href="{{ route('candidate.register') }}">{{ __('web.sign_up') }}</a></div>--}}
{{--                        <div class="divider"><span>or</span></div>--}}
{{--                        <div class="btn-box row">--}}
{{--                            <div class="col-lg-4 col-md-12">--}}
{{--                                <a href="{{ url('/login/facebook?type=1') }}"--}}
{{--                                   class="theme-btn social-btn-two facebook-btn"><i--}}
{{--                                            class="fab fa-facebook-f"></i> {{ __('web.login_menu.login_via_facebook') }}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-4 col-md-12">--}}
{{--                                <a href="{{ url('/login/google?type=1') }}"--}}
{{--                                   class="theme-btn social-btn-two google-btn"><i--}}
{{--                                            class="fab fa-google"></i> {{ __('web.login_menu.login_via_google') }}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-4 col-md-12">--}}
{{--                                <a href="{{ url('/login/linkedin?type=1') }}"--}}
{{--                                   class="theme-btn social-btn-two facebook-btn"><i--}}
{{--                                            class="fa fa-linkedin"></i> {{ __('web.login_menu.login_via_linkedin') }}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let registerSaveUrl = "{{ route('front.save.register') }}";
    </script>
    <script src="{{asset('assets/js/front_register/front_register.js?v=6.0.0')}}"></script>
@endsection
