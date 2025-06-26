<!-- Related Jobs -->
@if(count($getRelatedJobs)>0)
    <div class="related-jobs">
        <div class="title-box">
            <h3>{{ __('web.job_details.related_jobs') }}</h3>
        </div>
        <!-- Job Block -->
        <!-- Start of Row -->
        <div>
            <!-- Start of Job Post Wrapper -->
            @foreach($getRelatedJobs as $relatedJob)
                @if($relatedJob->status != \App\Models\Job::STATUS_DRAFT)
                    <div class="job-block">
                        <div class="inner-box">
                            <div class="content">
                                                    <span class="company-logo"><img
                                                            src="{{($job->company->getLogo()) ? $job->company->getLogo() : asset('assets/img/placeholder.png')}}"
                                                            alt=""></span>
                                <h4>
                                    <a href="{{route('front.job.details',$relatedJob['job_id']) }}">{{ html_entity_decode($relatedJob['job_title']) }}</a>
                                </h4>
                                <ul class="job-info mb-0">
                                    <li>
                                        <span class="icon flaticon-briefcase"></span> {{$relatedJob->jobCategory->name}}
                                    </li>
                                    <li>
                                        <span class="icon flaticon-map-locator"></span> {{ (!empty($relatedJob->full_location)) ? $relatedJob->full_location : __('web.web_jobs.location_not_available')}}
                                    </li>
                                    <li>
                                        <span class="icon flaticon-clock-3"></span> {{$relatedJob->created_at->diffForHumans()}}
                                    </li>
                                </ul>
                                @if($relatedJob->activeFeatured)
                                    <button class="bookmark-btn"><i
                                            class="fas fa-bookmark featured"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="row full-width-li">
            <div class="col-md-12 text-center pt30">
                <a href="{{ route('front.search.jobs') }}"
                   class="theme-btn btn-style-one">{{ __('web.common.show_all') }}</a>
            </div>
        </div>
    </div>
@endif
