{{--<div class="col-md-6 mt25">--}}
{{--    <div class="single-job-post row nomargin container-shadow">--}}
{{--        <div class="col-md-2 col-xs-6 nopadding">--}}
{{--            <img src="{{ $job->company->company_url }}" class="jobs-company-logo"--}}
{{--                 alt="company logo">--}}
{{--        </div>--}}
{{--        <div class="col-md-10 col-xs-6  nopadding-right nopadding-left">--}}
{{--            <div class="job-title">--}}
{{--                @if(Str::length($job->job_title) < 35)--}}
{{--                    <a href="{{ route('front.job.details',$job->job_id) }}" class="hover-color">--}}
{{--                        {{ html_entity_decode($job->job_title) }}</a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('front.job.details',$job->job_id) }}"--}}
{{--                       data-toggle="tooltip" data-placement="bottom" class="hover-color"--}}
{{--                       title="{{ html_entity_decode($job->job_title) }}">--}}
{{--                        {{ Str::limit(html_entity_decode($job->job_title),30,'...') }}</a>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="job-info">--}}
{{--                <span class="location one-line-ellip">--}}
{{--                @if(!empty($job->country_name))--}}
{{--                        <i class="fa fa-map-marker"></i>--}}
{{--                        @if(Str::length($job->full_location) < 45)--}}
{{--                            {{ $job->full_location }}--}}
{{--                        @else--}}
{{--                            <span data-toggle="tooltip" data-placement="bottom"--}}
{{--                                  title="{{$job->full_location}}">--}}
{{--                                {{ Str::limit($job->full_location,45,'...') }}</span>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                 </span>--}}
{{--            </div>--}}
{{--            <div class="job-category pull-left j-category-type">--}}
{{--                <a href="javascript:void(0)"--}}
{{--                   class="btn btn-orange btn-small btn-effect">--}}
{{--                    {{ $job->jobCategory->name }}--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @if($job->activeFeatured)--}}
{{--            <img src="{{ asset('web/img/icons8-star-64.png') }}" class="featured-img"--}}
{{--                 data-toggle="tooltip" data-placement="bottom" title="Featured">--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}
<div class="job-block-three col-lg-4 col-md-6 col-sm-12">
    <div class="inner-box h-100">
        <div class="content">
            <span class="company-logo"><img src="{{ $job->company->company_url }}" alt=""></span>
            <div class="d-flex">
            <h4>

            @if(Str::length($job->job_title) < 35)
                <a href="{{ route('front.job.details',$job->job_id) }}">
                    {{ html_entity_decode($job->job_title) }}</a>
            @else
                <a href="{{ route('front.job.details',$job->job_id) }}"
                   data-toggle="tooltip" data-placement="bottom" class="hover-color"
                   title="{{ html_entity_decode($job->job_title) }}">
                    {{ Str::limit(html_entity_decode($job->job_title),30,'...') }}</a>
            @endif
            </h4>
            </div>

        </div>
        <ul class="job-other-info">
            @foreach($job->jobsSkill->take(1) as $skills)
                <li class="time">{{$skills->name}}</li>
            @if(count($job->jobsSkill) -1 > 0)
                <li class="green">{{'+'.(count($job->jobsSkill) -1)}}</li>
                @endif
            @endforeach
        </ul>
        @if($job->activeFeatured)
            <button class="bookmark-btn"><i class="fas fa-bookmark featured"></i></button>
        @endif
    </div>
</div>
