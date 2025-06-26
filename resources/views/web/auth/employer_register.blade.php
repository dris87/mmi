@extends('web.layouts.app')
@section('title')
    {{__('messages.company.register_title')}}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web_front/css/header-span.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <!--Page Title-->
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{__('messages.company.register_title')}}</h1>
                <div class="title-description">
                    <div class="text">{{__('messages.company.register_subtitle')}}</div>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    <div class="login-section pt-5">
        <div class="register-form default-form container">
            <div class="form-inner">
                {{ Form::open(['id'=>'addEmployerNewForm']) }}
                <input type="hidden" name="type" value="2">
                <div class="form-group">
                    <h3>{{__('messages.company.company_details')}}</h3>
                    <div class="row">
                        <div class="form-group col-12 ">
                            <label>{{__('messages.company.vatNumber')}}:
                                <span class="required asterisk-size">*</span>
                            </label>
                            <input autocomplete="off" type="text" name="vatNumber" id="vatNumber" class="form-control" required>
                            <div class="form-tooltip">{{__('messages.company.vat_tooltip')}}</div>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('messages.company.company_name')}}:
                                <span class="required asterisk-size">*</span></label>
                            <input autocomplete="off" type="text" name="companyName" id="companyName" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <label>{{__('messages.company.zip_code')}}:
                                        <span class="required asterisk-size">*</span></label>
                                    <input autocomplete="off" type="text" name="zipCode" id="zipCode" class="form-control" required>
                                </div>
                                <div class="col-md-8 col-12">

                                    <label>{{__('messages.company.city')}}:
                                        <span class="required asterisk-size">*</span>
                                    </label>
                                    <input autocomplete="off" type="text" name="city" id="city" class="form-control" required>
                                    <div class="form-tooltip">{{__('messages.company.city_tooltip')}}.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-9 ">
                            <label>{{__('messages.company.street')}}:
                                <span class="required asterisk-size">*</span></label>
                            <input autocomplete="off" type="text" name="street" id="street" class="form-control" required>
                        </div>
                        <div class="form-group col-xs-12 col-md-3 ">
                            <label>{{__('messages.company.house_number')}}:
                                <span class="required asterisk-size">*</span></label>
                            <input autocomplete="off" type="text" name="houseNumber" id="houseNumber" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{__('messages.company.floor')}}:</label>
                                       <input autocomplete="off" type="text" name="floor" id="floor" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label>{{__('messages.company.door')}}:</label>
                                    <input autocomplete="off" type="text" name="door" id="door" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-12 ">
                            <label>{{__('messages.company.representative')}}:
                                <span class="required asterisk-size">*</span></label>
                            <input autocomplete="off" type="text" name="representative" id="representative" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h3>{{__('messages.company.contact_title')}}</h3>
                    <div class="row">
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <label>{{__('messages.company.surname')}}:
                                        <span class="required asterisk-size">*</span>
                                    </label>
                                    <input autocomplete="off" type="text" name="lastName" id="lastName" class="form-control" required>
                                    <div class="form-tooltip">{{__('messages.company.surname_tooltip')}}.</div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label>{{__('messages.company.firstname')}}:
                                        <span class="required asterisk-size">*</span>
                                    </label>
                                    <input autocomplete="off" type="text" name="firstName" id="firstName" class="form-control" required>
                                    <div class="form-tooltip">{{__('messages.company.firstname_tooltip')}}.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('messages.company.position')}}:
                                <span class="required asterisk-size">*</span>
                            </label>
                            {{ Form::select('position_id', $arrPositions, null, ['class' => 'form-control','required','id' => 'employerPosition','placeholder'=> __('messages.company.select_position')]) }}

                            <div class="form-tooltip">{{__('messages.company.position_tooltip')}}.</div>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('messages.company.phone')}}:
                                <span class="required asterisk-size">*</span>
                            </label>
                            <input autocomplete="off" type="number" name="phone" id="phone" class="form-control" required>
                            <div class="form-tooltip">{{__('messages.company.phone_tooltip')}}.</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h3>{{__('messages.company.account_details')}}</h3>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>{{__('messages.company.email')}}:
                                <span class="required asterisk-size">*</span>
                            </label>
                            <input  autocomplete="new-password" type="email" name="email" id="employerEmail" class="form-control" required>
                            <div class="form-tooltip">{{__('messages.company.email_tooltip')}}.</div>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('messages.company.password')}}:<span class="required asterisk-size">*</span>
                            </label>
                            <input  autocomplete="new-password" type="password" name="password" id="employerPassword" class="form-control" required onkeypress="return avoidSpace(event)">
                            <div class="form-tooltip">{{__('messages.company.password_tooltip')}}.</div>
                        </div>
                        <div class="form-group col-12">
                            <label>{{__('messages.company.confirm_password')}}:
                                <span class="required asterisk-size">*</span>
                            </label>
                            <input autocomplete="off" type="password" name="password_confirmation" id="employerConfirmPassword"
                                   class="form-control" required onkeypress="return avoidSpace(event)">
                            <div class="form-tooltip">{{__('messages.company.confirm_password_tooltip')}}.</div>
                        </div>
                    </div>
                    <div class="form-check mb20 mt-3">
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
                </div>
                @if($isGoogleReCaptchaEnabled)
                    <div class="form-group mt10">
                        <div class="g-recaptcha d-flex justify-content-center"
                             data-sitekey="{{ config('app.google_recaptcha_site_key') }}"></div>
                        <div id="g-recaptcha-error"></div>
                    </div>
                @endif
                <div class="form-group text-center nomargin mt-3">
                    <button type="submit" class="theme-btn btn-style-one" id="btnEmployerSave"
                            data-loading-text="<span class='spinner-border spinner-border-sm'></span> Kérem várjon...">
                        {{__('messages.company.register')}}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@if($isGoogleReCaptchaEnabled ?? '' ?? '')
@section('page_scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@endif

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CompanyRegisterRequest') !!}
    <script>
        let registerSaveUrl = "{{ route('front.save.register') }}";
        let employerLogInUrl = "{{ route('front.employee.login') }}";
        let isGoogleReCaptchaEnabled = "{{ (boolean)$isGoogleReCaptchaEnabled ?? '' ?? '' }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/front_register/front_register.js?v=6.0.0')}}"></script>
    @if($isGoogleReCaptchaEnabled ?? '' ?? '')
        <script src="{{asset('assets/js/front_register/google-recaptcha.js')}}"></script>
    @endif
@endsection
