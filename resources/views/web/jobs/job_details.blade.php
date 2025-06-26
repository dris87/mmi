@extends('web.layouts.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web_front/css/header-span.css') }}">
@endsection
@section('content')
    <section class="job-detail-section">
        <!-- Upper Box -->
        <div class="upper-box">
            <div class="auto-container">
                <!-- Job Block -->
                <div class="company-profile-header">
                    <div class="cover-photo" style="background-image: url({{($objCompany->getCoverPhoto()) ? $objCompany->getCoverPhoto() : asset('assets/img/placeholder.png')}});">
                    </div>
                    <div class="company-logo-web" style="background-image: url('{{($objCompany->getLogo()) ? $objCompany->getLogo() : asset('assets/img/placeholder.png')}}');">
                    </div>
                </div>

            </div>
        </div>
        <div class="auto-container">
                <div class="job-block-three">
                    <div class="inner-box">
                        <div class="content">
                            @if(!$fields['is_anonym'])
                            <span class="company-logo">
                                <a href="#">
                                <img src="{{($objCompany->getLogo()) ? $objCompany->getLogo() : asset('assets/img/placeholder.png')}}" alt="" class="job_detail_logo">
                            </a>
                            @endif
                            </span>
                            <h4>
                                <a href="#">{{ html_entity_decode(Str::limit($fields['job_title'],50,'...')) }}</a><br>
                                <div style="font-size: 16px;  color: #1C75BC;">{{ $objCompany->name }}</div>
                                @if($job && $job->activeFeatured)

                                    <span class="primary">Featured</span>
                                @endif
                            </h4>
                            <ul class="job-info">
                                    @foreach ($jobCategories as $category)
                                    <li>
                                        <span class="icon flaticon-briefcase"></span>
                                        {{ html_entity_decode($category->name) }}
                                    </li>
                                    @endforeach
                                        @if($job)
                                             <li><span class="icon flaticon-clock-3"></span> {{ $job->created_at->diffForHumans() }}
                                        @endif
                                </li>
                            </ul>
                            @if(count($jobTypes) > 0)
                                <ul class="job-other-info">
                                    @foreach($jobTypes as $jobType)
                                        <li class="time">{{ $jobType->name }}</li>
                                        {{--                                <li class="privacy">Private</li>--}}
                                        {{--                                <li class="required">Urgent</li>--}}
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if($job)
                            <div class="btn-box mt-2 mb-2">
                                @auth
                                    @role('Candidate')
{{--                                    <a href="#emailJobToFriendModal" class="theme-btn btn-style-four emailJobToFriend mb-sm-0 mb-3"--}}
{{--                                       rel="modal:open" data-backdrop="static"--}}
{{--                                       data-keyboard="false">{{ __('web.job_details.email_to_friend') }}</a>--}}
{{--                                    <a href="#reportJobAbuseModal"--}}
{{--                                       class="theme-btn btn-style-eight reportJobAbuse mb-sm-0 mb-3 {{ ($isJobReportedAsAbuse) ? 'disabled' : '' }}"--}}
{{--                                       rel="modal:open">{{ __('web.job_details.report_abuse') }}</a>--}}
                                    @if(!$isApplied && !$isJobApplicationRejected && ! $isJobApplicationCompleted && ! $isJobApplicationShortlisted)
{{--                                        @if($isActive && !$job->is_suspended && \Carbon\Carbon::today()->toDateString() < Carbon\Carbon::createFromFormat('Y-m-d', $fields['job_expiry_date'])->toDateString())--}}

                                        <?php

                                            $user = \Illuminate\Support\Facades\Auth::user();
                                            $cv_count = $user->candidate->getCandidateCVCount();

                                        ?>
                                            @if($cv_count)
                                            <button
                                                    class="theme-btn {{ $isJobDrafted ? 'btn-style-two' : 'btn-style-seven' }} "
                                                    onclick="window.location='{{ route('show.apply-job-form', $job->job_id) }}'">
                                                {{ $isJobDrafted ? __('web.job_details.edit_draft') : __('web.job_details.apply_for_job') }}
                                            </button>
                                            @else
                                                <div class="alert2 alert2-secondary" role="alert">
                                                    A állásra jelentkezéshez kérjük generáljon vagy töltsön fel legalább egy önéletrajzot</a>
                                                </div>
                                            @endif
{{--                                        @endif--}}
                                    @else
                                        <button class="theme-btn btn-style-four">{{ __('web.job_details.already_applied') }}</button>
                                                @endif
                                                    @if(!$isJobApplicationRejected)
                                                        <div class="bookmark-btn">
                                                            <button
                                                                    data-favorite-user-id="{{ (getLoggedInUserId() !== null) ? getLoggedInUserId() : null }}"
                                                                    data-favorite-job-id="{{ $job->id }}" id="addToFavourite"><i
                                                                    title="<?=$isJobAddedToFavourite?"Kedvencnek jelölve":"Kedvencnek jelölés"?>"
                                                                    class="{{ ($isJobAddedToFavourite)? 'fas fa-bookmark featured':'flaticon-bookmark' }}"></i></button>
                                                        </div>
                                                    @endif
                                    @endrole
                                                @else
                                                    @if($isActive && !$job->is_suspended && \Carbon\Carbon::today()->toDateString() < $job->job_expiry_date->toDateString())
                                                            <button class="theme-btn btn-style-one mb-3"
                                                                    onclick="window.location='{{ route('candidate.register') }}'">{{ __('web.job_details.register_to_apply') }}
                                                            </button>
                                                            <button class="theme-btn btn-style-seven"
                                                                    onclick="window.location='{{ route('front.candidate.login') }}'">
                                                                {{ __('web.job_details.apply_for_job') }}
                                                            </button>
                                        @endif
                                @endauth
                                @guest
                                        <div class="alert2 alert2-secondary" role="alert">
                                            A állásra jelentkezéshez kérjük <a href="/users/candidate-login">jelentkezzen be</a> a munkavállalói fiókjába vagy <a href="/candidate-register">regisztrájon</a>
                                        </div>
                                @endguest
                            </div>
                        @endif
                    </div>
                </div>
        </div>
        <div class="job-detail-outer">
            <div class="auto-container">
                <div class="row">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        {{--                        @if($job->is_suspended || !$isActive)--}}
                        {{--                            <div class="row">--}}
                        {{--                                <div class="col-md-12 col-sm-12">--}}
                        {{--                                    <div class="alert alert-warning text-warning bg-transparent" role="alert">--}}
                        {{--                                        {{ __('web.job_details.job_is') }}--}}
                        {{--                                        <strong> {{\App\Models\Job::STATUS[$job->status]}}.</strong>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @endif--}}
                        {{--                        @if(Session::has('warning'))--}}
                        {{--                            <div class="alert alert-warning" role="alert">--}}
                        {{--                                {{ Session::get('warning') }}--}}
                        {{--                                <a href="{{ route('candidate.profile',['section'=> 'resumes']) }}"--}}
                        {{--                                   class="alert-link ml-2 ">{{ __('web.job_details.click_here') }}</a> {{ __('web.job_details.to_upload_resume') }}--}}
                        {{--                                .--}}
                        {{--                            </div>--}}
                        {{--                        @endif--}}
                        <div class="job-detail">
                            <h4>{{ __('web.web_jobs.job_description') }}</h4>
                            @if($fields['description'])
                                <p>{!! nl2br($fields['description']) !!} </p>
                            @else
                                <p>{{ __('messages.common.field_left_empty') }}</p>
                            @endif
                            <h4>{{ __('messages.job.tasks') }}</h4>
                            @if($fields['tasks'])
                                <p>{!! nl2br($fields['tasks']) !!} </p>
                            @else
                                <p>{{ __('messages.common.field_left_empty') }}</p>
                            @endif
                            <h4>{{ __('web.job_details.requirements') }}</h4>
                            @if($fields['jobRequirements'])
                                {!! $requirementsHtml !!}
                            @else
                                <p>{{ __('messages.common.field_left_empty') }}</p>
                            @endif

                            <h4>{{ __('messages.job.advantages') }}</h4>
                            @if($fields['advantages'])
                                <p>{!! nl2br($fields['advantages']) !!} </p>
                            @else
                                <p>{{ __('messages.common.field_left_empty') }}</p>
                            @endif

                            <h4>{{ __('messages.job.perks') }}</h4>
                            @if($fields['perks'])
                                <p>{!! nl2br($fields['perks']) !!} </p>
                            @else
                                <p>{{ __('messages.common.field_left_empty') }}</p>
                            @endif


                        </div>

                        @auth
                    @endauth
                        <div class="d-md-block d-none">
                            @include('web/jobs/partials/share_buttons', array('url'=>$url, 'job' => $job ?? null))
                            @include('web/jobs/partials/related_jobs', array('getRelatedJobs'=>$getRelatedJobs))
                        </div>
                    </div>

                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar">
                            <div class="sidebar-widget">
                            <!-- Job Overview -->
                                <h4 class="widget-title">{{ __('web.web_jobs.job_overview') }}</h4>
    <div class="widget-content">
        <ul class="job-overview">
            <li>
                <i class="icon far fa-address-card"></i>
                <h5>{{ __('messages.job.position') }}:</h5>
                <span>{{ $fields['job_position'] }}</span>
            </li>

            <li>
                <i class="icon far fa-calendar-alt"></i>
                <h5>{{ __('web.job_details.date_posted') }}:</h5>
                                            <span>{{ $fields['job_release_date'] }}</span>
            </li>

            <li>
                <i class="icon far fa-hourglass"></i>
                <h5>{{ __('web.web_jobs.expiration_date') }}:</h5>
                                            <span>{{ $fields['job_expiry_date'] }}</span>
            </li>
            <li>
                <i class="icon far fa-user"></i>
                <h5>{{ __('web.job_details.candidate_count') }}:</h5>
                <span>{{ $fields['candidate_count'] }}</span>
            </li>
            <li>
                <i class="icon fas fa-map-marker-alt"></i>
                <h5>{{ __('web.job_details.location') }}</h5>
                                            <span>
                                                    @if(count($jobLocations) > 0)
                                                        <ul class="job-locations">
                                                            @foreach($jobLocations as $objCity)
                                                                <li class="city">{{ $objCity->name }}</li>
                                                                {{--                                <li class="privacy">Private</li>--}}
                                                                {{--                                <li class="required">Urgent</li>--}}
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @if(empty($jobLocations))
                                                    {{ __('web.job_details.location_information_not_available') }}
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            <i class="icon fas fa-divide"></i>
                                            <h5>{{__('web.job_details.job_type')}}:</h5>
                                            @if(count($jobTypes) > 0)
                                                <ul class="job-locations">
                                                    @foreach($jobTypes as $jobType)
                                                        <li class="city">{{ $jobType->name }}</li>
                                                        {{--                                <li class="privacy">Private</li>--}}
                                                        {{--                                <li class="required">Urgent</li>--}}
                                                    @endforeach
                                                </ul>
                                            @endif
                                            @if(empty($jobLocations))
                                                {{ __('messages.common.n/a') }}
                                            @endif
                                        </li>
                                        @if(count($jobShifts) > 0)
                                            <li>
                                                <i class="icon fas fa-clock"></i>
                                                <h5>{{__('messages.job.job_shift')}}:</h5>

                                                    <ul class="job-shifts">
                                                        @foreach($jobShifts as $jobShift)
                                                            <li class="job-shift">{{ $jobShift->shift }}</li>
                                                            {{--                                <li class="privacy">Private</li>--}}
                                                            {{--                                <li class="required">Urgent</li>--}}
                                                        @endforeach
                                                    </ul>

                                            </li>
                                        @endif
{{--                            @if($job->degreeLevel)--}}
{{--                <li>--}}
{{--                    <i class="icon fas fa-graduation-cap"></i>--}}
{{--                    <h5>{{__('messages.job.degree_level')}}:</h5>--}}
{{--                                            <span> {{ html_entity_decode($job->degreeLevel->name) }}</span>--}}
{{--                                        </li>--}}
{{--                            @endif--}}
{{--                                        <li>--}}
{{--                                            <i class="icon fas fa-crosshairs"></i>--}}
{{--                                            <h5>{{__('messages.positions')}}:</h5>--}}
{{--                                            <span>{{ isset($job->position)?$job->position:'0' }}</span>--}}
{{--                                        </li>--}}
{{--            <li>--}}
{{--                <i class="icon fas fa-briefcase"></i>--}}
{{--                <h5>{{__('messages.job_experience.job_experience')}}:</h5>--}}
{{--                                            <span> {{ isset($job->experience) ? $job->experience .' '. __('messages.candidate_profile.year') :'No experience' }}</span>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <i class="icon fas fa-funnel-dollar"></i>--}}
{{--                <h5>{{__('messages.job.salary_period')}}:</h5>--}}
{{--                                <span>{{ $job->salaryPeriod->period }}</span>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <i class="icon fas fa-user-tie"></i>--}}
{{--                <h5>{{__('messages.job.is_freelance')}}:</h5>--}}
{{--                                <span>{{ $job->is_freelance == 1 ? __('messages.common.yes') : __('messages.common.no') }}</span>--}}
{{--                            </li>--}}
{{--                             </ul>--}}
{{--                        </div>--}}

{{--                            <!-- Job Skills -->--}}
{{--                                <h4 class="widget-title">{{ __('web.job_details.job_skills') }}</h4>--}}
{{--                                <div class="widget-content">--}}
{{--                                    <ul class="job-skills">--}}
{{--                                        @if($job->jobsSkill->isNotEmpty())--}}
{{--                                            @foreach($job->jobsSkill->pluck('name') as $key => $value)--}}
{{--                                                <li>--}}
{{--                                                    <a>{{html_entity_decode($value) }}</a>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        @else--}}
{{--                                            <p>N/A</p>--}}
{{--                                        @endif--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            @if(!$fields['is_anonym'])
                            <div class="sidebar-widget company-widget">
                                <div class="widget-content">
                                    <h4 class="widget-title">{{ __('web.job_details.company_overview') }}</h4>
                                    <div class="company-title">
                                        <div class="company-logo"><img src="{{($objCompany->getLogo()) ? $objCompany->getLogo() : asset('assets/img/placeholder.png')}}" alt=""
                                                                       class="company_overview">
                                        </div>
                                        <h5 class="company-name">{{ html_entity_decode($fields['company']['name']) }}</h5>
{{--                                        <a href="{{ route('front.company.details', $fields['company']['unique_id']) }}" class="profile-link">{{ __('web.web_jobs.view_company_profile') }}</a>--}}
                                        <a href="##" class="profile-link">{{ __('web.web_jobs.view_company_profile') }}</a>
                                    </div>
                                    <ul class="company-info">
                                        {{--                                        <li>Primary industry: <span></span></li>--}}
                                        {{--                                        <li>Company size: <span></span></li>--}}

                                        @if($fields['companyUser']['phone'])
                                        <li>{{ __('web.web_jobs.phone') }}: <span>{{$fields['companyUser']['phone']}}</span></li>
                                        @endif
                                        <li>{{ __('web.common.companyLocation') }}: <span>
                                                @if (!empty($fields['companyCity']))
                                                    {{$fields['company']['street']}} {{$fields['company']['address']}}
                                                    @if($fields['company']['floor'])
                                                         <br/>{{$fields['company']['floor']}} {{$fields['company']['door']}}
                                                    @endif
                                                    <br/>{{$fields['companyCity'][0]}}
                                                    <br/>{{$fields['companyPostCode'][0]}}
                                                @endif
                                                @if (empty($fields['companyCity']))
                                                    {{ __('web.job_details.location_information_not_available') }}
                                                @endif</span></li>
                                        {{--                                        <li>Social media:--}}
                                        {{--                                            <div class="social-links">--}}
                                        {{--                                                <a href="#"><i class="fab fa-facebook-f"></i></a>--}}
                                        {{--                                                <a href="#"><i class="fab fa-twitter"></i></a>--}}
                                        {{--                                                <a href="#"><i class="fab fa-instagram"></i></a>--}}
                                        {{--                                                <a href="#"><i class="fab fa-linkedin-in"></i></a>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </li>--}}
                                    </ul>
                                    <div class="btn-box">
{{--                                        <a href="{{ route('front.company.details', $fields['company']['unique_id']) }}" class="w-100 btn-style-four mb-2">{{ __('web.companies_menu.opened_jobs') }}:{{ $jobsCount?$jobsCount : 0 }} </span></a>--}}
                                        <a href="##" class="w-100 btn-style-four mb-2">{{ __('web.companies_menu.opened_jobs') }}:{{ $jobsCount?$jobsCount : 0 }} </span></a>
                                    </div>
                                </div>
                            </div>
                                @endif
                        </aside>
                    </div>
                    <div class="d-md-none d-block">
                        <div class="related-jobs-mobile">
                            <div class="col-12">
                                @include('web/jobs/partials/share_buttons', array('url'=>$url, 'objCompany'=>$objCompany, 'job' => $job ?? null))
                                @include('web/jobs/partials/related_jobs', array('getRelatedJobs'=>$getRelatedJobs))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @role('Candidate')
    @include('web.jobs.email_to_friend')
    @include('web.jobs.report_job_modal')
    @endrole
@endsection
@section('scripts')
    <script>
        let addJobFavouriteUrl = "{{ route('save.favourite.job') }}";
        let reportAbuseUrl = "{{ route('report.job.abuse') }}";
        let emailJobToFriend = "{{ route('email.job') }}";
        let isJobAddedToFavourite = "{{ $isJobAddedToFavourite }}";
        let removeFromFavorite = "{{ __('web.job_details.remove_from_favorite') }}";
        let addToFavorites = "{{ __('web.job_details.add_to_favorite') }}";
    </script>
    <script src="{{ asset('assets/js/jobs/front/job_details.js?v=5.0.0') }}"></script>
@endsection
