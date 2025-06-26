<div class="other-options">
    <div class="social-share flex-wrap">
        <div class="col-md-3">
            <h5>{{ __('web.apply_for_job.share_this_job') }}</h5>
        </div>
        <div class="col-md-9 d-flex flex-wrap">

            <?=$objCompany->website?'<a href="'.$objCompany->website.'" target="_blank" class="twitter d-flex d-flex"><i class="fa fa-link linkedin-fa-icon"></i>'.__('web.web_jobs.website').'</a>':"";?>
            <?=$objCompany->facebook_url?'<a href="'.$objCompany->facebook_url.'" target="_blank" class="facebook d-flex"><i class="fab fa-facebook-f"></i>'.__('web.web_jobs.facebook').'</a>':"";?>
            <?=$objCompany->google_plus_url?'<a href="'.$objCompany->google_plus_url.'" target="_blank" class="google d-flex"><i class="fab fa-google"></i>'.__('web.web_jobs.google').'</a>':"";?>
            <?=$objCompany->linkedin_url?'<a href="'.$objCompany->linkedin_url.'" target="_blank" class="linkedin d-flex"><i class="fab fa-linkedin"></i>'.__('web.web_jobs.linkedin').'</a>':"";?>

        </div>
    </div>
</div>
