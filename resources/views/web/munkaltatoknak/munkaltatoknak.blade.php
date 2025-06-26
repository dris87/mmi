@extends('web.layouts.app')
@section('title')
    {{ __('web.for_companies') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web_front/css/header-span.css') }}">
@endsection
@section('content')
    <!--Page Title-->
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{ __('web.for_companies') }}</h1>
                <div class="title-description">
                    <div class="text">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor.</div>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    @guest
    <section class="employer-login-section section-padding" style="padding: 50px 0 50px;">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="default-form login-form">
                         @include('web.layouts.partials.login_form',['isCandidate' => 0])
                    </div>
                </div>
                <div class="col-lg-6 col-12 d-flex align-items-center justify-content-center">
                    <div class="register-prompt text-center">

                        <div class="sec-title">
                            <h2>Nincs még fiókja?</h2>
                        </div>
                        <a href="{{ route('front.page.employer_register') }}" class="theme-btn btn-style-one"><i class="la la-briefcase mr-1"></i>
                             Cégfiók létrehozása
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest
    <section class="work-section style-two" style="padding: 50px 0 50px;">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h2>Miért minket válasszon?</h2>
                <div class="text">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor.</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ullamcorper rutrum eros, a fermentum odio pulvinar at. Proin non venenatis eros. Donec mattis tincidunt viverra. Praesent at posuere ligula. Sed vehicula ipsum vel fermentum consequat. Nam suscipit, sapien non ullamcorper molestie, ante tellus tempus augue, non dignissim leo nisi ac leo. Donec interdum ullamcorper eros at ultricies. Fusce tincidunt, odio sed gravida sodales, dolor mauris volutpat dui, eget tempor arcu felis a dolor. Praesent ultrices, velit ut tempus efficitur, odio nibh pulvinar dolor, non egestas justo ante et ipsum. In ex sem, volutpat a blandit non, tempor quis enim.
                </div>
                <div class="col-lg-6 col-12">
                    In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ullamcorper rutrum eros, a fermentum odio pulvinar at. Proin non venenatis eros. Donec mattis tincidunt viverra. Praesent at posuere ligula. Sed vehicula ipsum vel fermentum consequat. Nam suscipit, sapien non ullamcorper molestie, ante tellus tempus augue, non dignissim leo nisi ac leo. Donec interdum ullamcorper eros at ultricies. Fusce tincidunt, odio sed gravida sodales, dolor mauris volutpat dui, eget tempor arcu felis a dolor. Praesent ultrices, velit ut tempus efficitur, odio nibh pulvinar dolor, non egestas justo ante et ipsum. In ex sem, volutpat a blandit non, tempor quis enim.


                </div>
            </div>
        </div>
    </section>

    <!-- End Work Section -->
    @if(count($plans) > 0)
        <!-- Pricing Section -->
        <section class="pricing-section" style="padding: 50px 0 50px;">
            <div class="auto-container">
                <div class="sec-title text-center">
                    <h2>Csomagok</h2>
                    <div class="text">Lorem ipsum dolor sit amet elit, sed do eiusmod tempor.</div>
                </div>
                <!--Pricing Tabs-->
                <div class="pricing-tabs tabs-box wow fadeInUp">
                    <!--Tab Btns-->
                    <div class="tabs-content">
                        <!--Tab / Active Tab-->
                        <div class="tab active-tab" id="monthly">
                            <div class="content">
                                <div class="row justify-content-center">
                                    @foreach($plans as $plan)
                                        <div class="pricing-table col-lg-4 col-md-6 col-sm-12">
                                            <div class="inner-box">
                                                <div class="title">{{$plan->name}}</div>
                                                <div class="price">@if($plan->amount) {{$plan->amount}} {{trans('messages.plan.local_currency')}}<span class="price-suffix">{{ trans('messages.plan.price_suffix')}}</span> @else {{ trans('messages.common.free') }}@endif
                                                </div>
                                                <div class="table-content">
                                                    <div class="table-section">
                                                        <div class="table-section-label resolves">{{trans('messages.common.resolves')}}</div>
                                                        <span>  {{$plan->allowed_jobs }} db</span>
                                                    </div>
                                                    <div class="table-section">
                                                        <div class="table-section-label  validity">{{trans('messages.common.validity')}}</div>
                                                        <span>{{$planValidYears}} {{ trans('messages.common.year') }}</span>
                                                    </div>
                                                    @if($plan->services()->count() > 0)
                                                        <div class="table-section">
                                                            <div class="table-section-label  services">{{trans('messages.common.services')}}</div>
                                                            <ul>
                                                                @foreach($plan->services()->get()->all() as $planService)
                                                                <li>{{$planService->service()->get()->first()->name}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="table-footer">
                                                    @if(Auth::check() && Auth::user()->hasRole('Candidate'))
                                                        <a href="#"
                                                           class="theme-btn btn-style-three d-none">{{ __('messages.pricing_table.get_started') }}</a>
                                                    @elseif(Auth::check() && Auth::user()->hasRole('Employer'))
                                                        <div class="add-to-cart">
                                                            <form id="packageAddToCartForm" method="POST">
                                                                <input type="hidden" name="package_id" value="{{$plan->id}}" />
                                                                <div class="row">
                                                                    <div class="col-md-3 col-12">
                                                                        <input type="number" class="h-100 text-center form-control" name="quantity" min="1" value="1" />
                                                                    </div>
                                                                    <div class="col-md-9 col-12">
                                                                        <input type="submit" class="w-100 theme-btn btn-style-three" name="addToCart" value="{{ __('messages.pricing_table.get_started') }}" />
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @elseif(Auth::check() && Auth::user()->hasRole('Admin'))
                                                        <a href="#"
                                                           class="theme-btn btn-style-three d-none">{{ __('messages.pricing_table.get_started') }}</a>
                                                    @else
                                                        <a href="{{ route('front.page.employer_register') }}"
                                                           class="theme-btn btn-style-three">{{ __('messages.pricing_table.get_started') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
{{--                                    @foreach($plans as $plan)--}}
{{--                                        <div class="pricing-table col-lg-4 col-md-6 col-sm-12">--}}
{{--                                            <div class="inner-box">--}}
{{--                                                <div class="title">{{ html_entity_decode( Str::limit($plan->name, 12, '...') ) }}</div>--}}
{{--                                                <div class="price">{{ $plan->amount }}{{empty($plan->salaryCurrency->currency_icon)?'$':$plan->salaryCurrency->currency_icon}}--}}
{{--                                                    <span class="duration"><label--}}
{{--                                                            class="font-weight-bolder ">/{{ __('web.web_home.monthly') }}</label></span>--}}
{{--                                                </div>--}}
{{--                                                <div class="table-content">--}}
{{--                                                    <ul>--}}
{{--                                                        <li>--}}
{{--                                                            <span>  {{ $plan->allowed_jobs.' '.($plan->allowed_jobs > 1 ? __('messages.plan.jobs_allowed') : __('messages.plan.job_allowed')) }}</span>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                </div>--}}
{{--                                                <div class="table-footer">--}}
{{--                                                    @if(Auth::check() && Auth::user()->hasRole('Candidate'))--}}
{{--                                                        <a href="#"--}}
{{--                                                           class="theme-btn btn-style-three d-none">{{ __('messages.pricing_table.get_started') }}</a>--}}
{{--                                                    @elseif(Auth::check() && Auth::user()->hasRole('Employer'))--}}
{{--                                                        <a href="{{ route('manage-subscription.index') }}"--}}
{{--                                                           class="theme-btn btn-style-three">{{ __('messages.pricing_table.get_started') }}</a>--}}
{{--                                                    @elseif(Auth::check() && Auth::user()->hasRole('Admin'))--}}
{{--                                                        <a href="#"--}}
{{--                                                           class="theme-btn btn-style-three d-none">{{ __('messages.pricing_table.get_started') }}</a>--}}
{{--                                                    @else--}}
{{--                                                        <a href="{{ route('front.page.employer_register') }}"--}}
{{--                                                           class="theme-btn btn-style-three">{{ __('messages.pricing_table.get_started') }}</a>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ route('front.page.employer_register') }}" class="theme-btn btn-style-one"><i class="la la-briefcase mr-1"></i>
                        Cégfiók létrehozása
                    </a>
                </div>
            </div>
        </section>
    @endif
    <!-- End Pricing Section -->

    <!-- Work Section -->
    <section class="work-section style-two" style="padding: 50px 0 50px;">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h2>Lépésről lépésre</h2>
                <div class="text">{{ __('web.web_jobSeeker.job_for_anyone_anywhere') }}</div>
            </div>

            <div class="employer-workflow-slider owl-carousel owl-theme">
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">

                        <i class="fa fa-sign-in-alt steps_icons"></i>
                        <h5 class="uppercase text-purple pt20 step-no">1. Lépés</h5>
                        <h5>Cégfiók létrehozása</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>

                    </div>
                </div>
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">

                        <i class="fa fa-list steps_icons"></i>

                        <h5 class="uppercase text-purple pt20 step-no">2. Lépés</h5>
                        <h5>Hirdetésfeladás</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>
                    </div>
                </div>
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">
                        <i class="fa fa-id-card steps_icons"></i>


                        <h5 class="uppercase text-purple pt20 step-no">3. Lépés</h5>
                        <h5>Önéletrajzok</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>

                    </div>
                </div>
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">
                        <i class="fa fa-credit-card steps_icons"></i>
                        <h5 class="uppercase text-purple pt20 step-no">4. Lépés</h5>
                        <h5>Csomag vásárlás</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>

                    </div>
                </div>
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">
                        <i class="fa fa-search steps_icons"></i>
                        <h5 class="uppercase text-purple pt20 step-no">5. Lépés</h5>
                        <h5>Bővített szűrő</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>

                    </div>
                </div>
                <!-- Work Block -->
                <div class="work-block">
                    <div class="inner-box h-100">
                        <i class="fa fa-check-circle steps_icons"></i>
                        <h5 class="uppercase text-purple pt20 step-no">6. Lépés</h5>
                        <h5>Kiválasztás</h5>
                        <p>In luctus diam sit amet eros placerat, quis tincidunt ante ultrices. Morbi ipsum enim, ullamcorper et turpis vel, laoreet accumsan lacus. Vestibulum a justo ut orci maximus tincidunt. Curabitur a rutrum nibh, et consectetur lacus. </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


