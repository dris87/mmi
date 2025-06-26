@extends('web.layouts.app')
@section('title')
    {{ __('web.job_menu.search_job') }}
@endsection
@section('css')
    <link href="{{ asset('assets/css/ion.rangeSlider.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('web_front/css/header-span.css') }}">
@endsection
@section('page_css')
    @if(\Illuminate\Support\Facades\App::getLocale() == 'ar')
        <style>
            .job-post-wrapper ul.pagination {
                direction: rtl;
            }
        </style>
    @endif
    <style>
        .job-post-wrapper ul.pagination {
            margin-top: 30px !important;
        }
    </style>
@endsection
@section('content')

    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <?php
                if(isset($relevant)){?>

                    <h1>{{ __('messages.candidate.relevant_jobs') }}</h1>
                    <ul class="page-breadcrumb" >
                        <li style="    text-transform: initial;">Az adatlapján kiválasztott állás kategóriák és maximális utazási távolság szerinti állások listája. <br>A keresési feltételeket módosíthatja.</li>
                    </ul>
                <?php
                }else{
                    ?>
                    <h1>{{ __('web.job_menu.search_job') }}</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('front.home') }}">{{ __('web.home') }}</a></li>
                        <li>{{ __('web.jobs') }}</li>
                    </ul>
                 <?php
                }
                ?>


            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Listing Section -->
    <section class="ls-section">
        <div class="auto-container">
            <div class="filters-backdrop"></div>

            <div class="row">

                {{--                <!-- Filters Column -->--}}
                <div class="filters-column col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="filters-outer" style="float: left">
                            <button type="button" class="theme-btn close-filters">X</button>
                            <!-- Filter Block -->
                            <div class="filter-block d-flex justify-content-between">
                                <div>
                                    <h4>{{ __('web.web_jobs.search_by_keywords') }}</h4>
                                </div>
                                <div>
                                    <button
                                        class="theme-btn small btn-style-eight reset-filter">{{ __('web.reset_filter') }}</button>
                                </div>
                            </div>


                            <div class="filter-block">
                                <div class="form-group">
                                    <input type="search" name="listing-search" id="searchByLocation"
                                           placeholder="@lang(('web.web_home.job_title_keywords_company'))">
                                    <span class="icon flaticon-search-3"></span>
                                </div>
                            </div>

                            <div class="filter-block">
                                <h4>Település</h4>
                                <div class="form-group">
                                    <input type="search" name="city-search" id="searchByCity"
                                           placeholder="Település, város neve..">
                                    <span class="icon flaticon-map-locator"></span>
                                </div>
                            </div>

                            <a href="javascrpt:void(0)" class="advanced_filters_button" >Részletes kereső
                            </a>

                            <div class="advanced_filters " >

                                <div class="filter-block multiple-choices">
                                    <h4>{{ __('messages.job_category.job_category') }}</h4>
                                    <div class="form-group">

                                        @if($jobCategories->isNotEmpty())
                                            <select class="chosen-select" multiple data-live-search="true" data-size="5"
                                                    name="search-categories" id="searchCategories" data-placeholder="{{ __('web.job_menu.none') }}">

                                                @foreach($jobCategories as $key => $value)
                                                    <?php
                                                    $categoires = explode(",",request()->get('categories'));
                                                    ?>
                                                    <option
                                                        value="{{ $key }}" <?= in_array($key,$categoires) ? 'selected' : '' ?>>
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-briefcase"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <h4>{{ __('messages.job.job_shift') }}</h4>
                                    <div class="form-group">
                                        @if($jobShifts->isNotEmpty())
                                            <select class="chosen-select" data-live-search="true" data-size="5"
                                                    name="search-shifts" id="searchShifts">
                                                <option value="">{{ __('web.job_menu.none') }}</option>
                                                @foreach($jobShifts as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-clock-3"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <h4>{{ __('messages.job_requirements.education_level') }}</h4>
                                    <div class="form-group">
                                        @if($requiredDegreeLevels->isNotEmpty())
                                            <select class="chosen-select" data-live-search="true" data-size="5"
                                                    name="search-requiredDegreeLevels" id="searchRequiredDegreeLevels">
                                                <option value="">{{ __('web.job_menu.none') }}</option>
                                                @foreach($requiredDegreeLevels as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-notebook"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <h4>{{ __('messages.job_requirement_types.language_skill') }}</h4>
                                    <div class="form-group">
                                        @if($language->isNotEmpty())
                                            <select class="chosen-select" data-live-search="true" data-size="5"
                                                    name="search-language" id="searchLanguage">
                                                <option value="">{{ __('web.job_menu.none') }}</option>
                                                @foreach($language as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-map"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <h4>{{ __('messages.job_requirement_types.drivers_license') }}</h4>
                                    <div class="form-group">
                                        @if($drivingLicences->isNotEmpty())
                                            <select class="chosen-select" data-live-search="true" data-size="5"
                                                    name="search-drivingLicences" id="searchDrivingLicences">
                                                <option value="">{{ __('web.job_menu.none') }}</option>
                                                @foreach($drivingLicences as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-car"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <h4>{{ __('messages.job_requirement_types.employment_type') }}</h4>
                                    <div class="form-group">
                                        @if($jobTypes->isNotEmpty())
                                            <select class="chosen-select" data-live-search="true" data-size="5"
                                                    name="job-types" id="searchJobTypes">
                                                <option value="">{{ __('web.job_menu.none') }}</option>
                                                @foreach($jobTypes as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ html_entity_decode($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="icon flaticon-workers"></span>
                                    </div>
                                </div>
                                <div class="filter-block">
                                    <ul>
                                        @auth
                                            <label class="text-dark mt10">Maximális távolág:</label>
                                            <li class="full-width-li">
                                                <input type="text" id="maxDistance" value="<?=null!==request()->get('maxDistance')?request()->get('maxDistance'):0?>">
                                            </li>
                                        @endauth
                                        <label class="text-dark mt10">{{ __('messages.candidate.experience') }}:</label>
                                        <li class="full-width-li">
                                            <input type="text" id="jobExperience">
                                        </li>
                                    </ul>
                                </div>

                                <a href="javascrpt:void(0)" class="simple_filters_button" >Egyszerű kereső
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--                <!-- Content Column -->--}}
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
                    <div class="ls-outer">
                        @livewire('job-search')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Listing Page Section -->
@endsection
@section('page_scripts')
@endsection
@section('scripts')
    <script>
        // $('.selectpicker').selectpicker({
        //     dropupAuto: false,
        // });
        let addJobFavouriteUrl = "<?php echo e(route('save.favourite.job')); ?>";
        let removeFromFavorite = "<?php echo e(__('web.job_details.remove_from_favorite')); ?>";
        let input = JSON.parse('@json($input)');
    </script>
    <script src="{{ asset('assets/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/jobs/front/job_search.js?v=4.0.0') }}"></script>
    <script>
        $(document).ready(function (){
            console.log("click");
            $("body").trigger("click");
        })
    </script>
@endsection
