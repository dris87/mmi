@extends('web.layouts.app')
@section('title')
    {{ __('web.login') }}
@endsection
@section('content')
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{asset('web_front/images/background/login.jpeg')}});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form">
                <div class="form-inner" id="candidate">
                    <h3>{{ __('web.login_header.employer_login') }}</h3>
                    <!--Login Form-->
                    @include('flash::message')
                    <div class="form-group">
                        <div class="btn-box row">
                            <div class="col-lg-6 col-md-12">
                                <a href="{{route('front.candidate.login')}}" class="theme-btn btn-style-four"><i class="la la-user"></i>
                                    {{ __('web.common.candidate') }} </a>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <a href="{{ route('front.employee.login') }}" class="theme-btn btn-style-seven"><i class="la la-briefcase"></i>
                                    {{ __('web.common.employer') }} </a>
                            </div>
                        </div>
                    </div>
                    @include('web.layouts.partials.login_form',['isCandidate' => 0])
{{--                    <div class="bottom-box">--}}
{{--                        <div class="text">Nincs még fiókja? <a--}}
{{--                                    href="{{ route('front.page.employer_register') }}">{{ __('web.sign_up') }}</a></div>--}}
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
