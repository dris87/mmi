<div>


@forelse($jobs as $job)
    <?php $allAttributes = $job->getAttributes();?>

    <?php
    $applied = "";
    if (\Illuminate\Support\Facades\Auth::user()) {
        foreach ($job->jobApplications as $objApplication) {
            if (\Illuminate\Support\Facades\Auth::user()->id == $objApplication->candidate->user->id) {
                $applied = '<h5><span class="badge badge-success">' . __(
                        'web.apply_for_job.already_applied'
                    ) . '</span></h5>';
                break;
            }
        }
    }
    ?>

    <!-- Job Block -->
        <div class="job-block">
            <div class="inner-box">
                <div class="content">
                    <span class="company-logo"><img
                            src="{{($job->company->getLogo()) ? $job->company->getLogo() : asset('assets/img/placeholder.png')}}"
                            alt=""
                            class="company-img"></span>

                    <h4>
                        <a href="{{route('front.job.details',$job['job_id']) }}">{{ html_entity_decode($job['job_title']) }}</a>

                        <div style="font-size: 17px; color: #1C75BC; padding-top: 4px;">{{ $job->company->name }}</div>

                        <?php
                        if( $job->company->website || $job->company->facebook_url || $job->company->google_plus_url || $job->company->linkedin_url ){
                            ?>
                            <div class="social-links job-card">
                                <?=$job->company->website?'<a target="_blank" href="'.$job->company->website.'"><i class="fa fa-link linkedin-fa-icon"></i></a>':""?>
                                <?=$job->company->facebook_url?'<a target="_blank" href="'.$job->company->facebook_url.'"><i class="fab fa-facebook"></i></a>':""?>
                                <?=$job->company->google_plus_url?'<a target="_blank"  href="'.$job->company->google_plus_url.'"> <i class="fab fa-google-plus-g google-plus-fa-icon"></i></a>':""?>
                                <?=$job->company->linkedin_url?'<a target="_blank"  href="'.$job->company->linkedin_url.'"> <i class="fab fa-linkedin-in linkedin-fa-icon"></i></a>':""?>
                            </div>
                            <?php
                        }
                        ?>

                        @if($applied)
                            <div style="padding-top: 13px;"><?= $applied ?></div>
                        @endif
                    </h4>
                    @auth
                        <div class="bookmark-btn">
                            <button
                                data-favorite-user-id="{{ (getLoggedInUserId() !== null) ? getLoggedInUserId() : null }}"
                                data-favorite-job-id="{{ $job->id }}" class="addToFavourite" ><i
                                    title="<?=$job->is_favourite?"Kedvencnek jelölve":"Kedvencnek jelölés"?>"
                                    class="{{ ($job->is_favourite)? 'fas fa-bookmark featured':'flaticon-bookmark' }}"></i></button>
                        </div>
                    @endauth

                    <ul class="job-info">
                        {{--                        <li><span class="icon flaticon-briefcase"></span> {{$job->jobCategory->name}}</li>--}}
                        <li>
                            <span class="icon flaticon-map-locator"></span>
                            <?php

                            $city_names = [];
                            foreach ($job->jobLocations as $jobLocation) {
                                $city_names[] = $jobLocation->city->name;
                            }
                            $city_names_coma = implode(", ", $city_names);

                            ?>
                            {{ (!empty($job->jobLocations)) ? $city_names_coma : 'Location Info. not available.'}}
                        </li>
                        @auth
                            <?php
                            if(isset($allAttributes["distance"]) && !empty($allAttributes["distance"])){
                            ?>
                            <li>
                                <span class="icon flaticon-car"></span> <?= round($allAttributes["distance"] / 1000) ?> km
                            </li>
                            <?php
                            }
                            else{
                                ?>
                            <li><span class="icon flaticon-car"></span> Helyben</li>
                                <?php
                            }
                            ?>
                        @endauth

                        <li>
                            <span class="icon flaticon-clock-3"></span> {{$job->created_at->diffForHumans()}}
                        </li>
                        {{--                        <li><span class="">{{$job->currency->currency_icon}}</span> {{$job->salary_from}}--}}
                        {{--                            - {{$job->salary_to}}</li>--}}
                    </ul>
                    <ul class="job-other-info job-badge">
                        @foreach($job->jobsSkill->take(1) as $jobSkill)
                            <li class="time">{{$jobSkill->name}}</li>
                            @if(count($job->jobsSkill) -1 > 0)
                                <li class="green">{{'+'.(count($job->jobsSkill) - 1)}}</li>
                            @endif
                        @endforeach
                    </ul>
                    <ul>
                        <?php
                        if(mb_strlen($job->description)>300){

                            $result = mb_substr($job->description, 0, 300);
                            echo  $result."...";
                        }else{
                            echo  $job->description;
                        }

                        ?>
                    </ul>

                    @if($job->activeFeatured)
                        <button class="bookmark-btn"><i class="fas fa-bookmark featured"></i></button>
                    @endif
                </div>
            </div>
        </div>

    @empty
        <div class="col-md-12 text-center">{{ __('web.job_menu.no_results_found') }}</div>
    @endforelse

    @if($jobs->count() > 0)
        {{$jobs->links() }}
    @endif
</div>
