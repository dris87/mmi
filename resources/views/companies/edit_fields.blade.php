<div class="company-profile-header">
    <div class="cover-photo" style="background-image: url({{($company->getCoverPhoto()) ? $company->getCoverPhoto() : asset('assets/img/placeholder.png')}});">
    </div>
    <div class="company-logo" style="background-image: url({{($company->getLogo()) ? $company->getLogo() : asset('assets/img/placeholder.png')}});">
    </div>
</div>

{{--<div class="company-name-title text-center">--}}
{{--    <h2>{{$company ? $company->name : null}}</h2>--}}
{{--</div>--}}
<div class="row">
    <div class="form-group col-12">
        <label>{{__('messages.company.display_name')}}:</label>
        {{ Form::text('display_name', $company ? $company->display_name : null, ['id'=> 'display_name', 'class' => 'form-control','required']) }}
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.appearance')}}</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-6 col-12">
            <label>{{__('messages.company.logo')}}:</label>
            <label for="company_logo" class="image__file-upload"> {{ __('messages.setting.choose') }}</label>
            {{ Form::file('logo',['id'=>'company_logo','class' => 'company-logo-uploader']) }}
        </div>
        <div class="col-md-6 col-12">
            <label>{{__('messages.company.cover_photo')}}:</label>
            <label for="company_cover_photo" class="image__file-upload"> {{ __('messages.setting.choose') }}</label>
            <div>{{ Form::file('cover_photo',['id'=>'company_cover_photo','class' => 'cover-photo-uploader']) }}</div>
        </div>
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.billing_details')}}</div>
<div class="form-group">
    <div class="row">
        <div class="form-group col-md-6 col-12">
            <label>{{__('messages.company.company_name')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('companyName', $company ? $company->name : null, ['id'=> 'companyName', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-md-6 col-12">
            <label>{{__('messages.company.representative')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('representative', $company ? $company->representative : null, ['class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-md-6 col-12">
            <label>{{__('messages.company.vatNumber')}}:
                <span class="required asterisk-size">*</span>
            </label>
            {{ Form::text('vatNumber', $company ? $company->vatNumber : null, ['id'=> 'vatNumber', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-md-6 col-12">
            <label>{{__('messages.company.company_number')}}:</label>
            {{ Form::text('companyNumber', $company ? $company->company_number : null, ['id'=> 'companyNumber', 'class' => 'form-control']) }}
        </div>
        <div class="col-12"><h4>{{__('messages.company.headquarters')}}</h4></div>
        <div class="form-group col-12">
            <div class="row">
                <div class="col-md-4 col-12">
                    <label>{{__('messages.company.zip_code')}}:
                        <span class="required asterisk-size">*</span></label>
                    {{ Form::text('zipCode', $postcode ? $postcode->postal_code : null, ['id'=> 'zipCode', 'class' => 'form-control','required']) }}

                </div>
                <div class="col-md-8 col-12">

                    <label>{{__('messages.company.city')}}:
                        <span class="required asterisk-size">*</span>
                    </label>
                    {{ Form::text('city', $city ? $city->name : null, ['id'=> 'city', 'class' => 'form-control','required']) }}
                    <div class="form-tooltip">{{__('messages.company.city_tooltip')}}.</div>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-md-9 ">
            <label>{{__('messages.company.street')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('street', $company ? $company->street : null, ['id'=> 'street', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-xs-12 col-md-3 ">
            <label>{{__('messages.company.house_number')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('houseNumber', $company ? $company->address : null, ['id'=> 'houseNumber', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-12">
            <div class="row">
                <div class="col-md-6">
                    <label>{{__('messages.company.floor')}}:</label>
                    {{ Form::text('floor', $company ? $company->floor : null, ['id'=> 'floor', 'class' => 'form-control','required']) }}
                </div>
                <div class="col-md-6">
                    <label>{{__('messages.company.door')}}:</label>
                    {{ Form::text('door', $company ? $company->door : null, ['id'=> 'door', 'class' => 'form-control','required']) }}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="custom-switch pl-0">
                    <span class="pr-3">{{__('messages.company.paper_invoice_requested')}}</span>
                    <input type="checkbox" name="is_paper_invoice" class="custom-switch-input"
                           value="1" @if(isset($company->is_paper_invoice)) checked="checked" @endif>
                    <span class="custom-switch-indicator"></span>
                </label>
            </div>
        </div>
        <div class="col-12"><h4>{{__('messages.company.mailing_address')}}</h4></div>
        <div class="form-group col-12">
            <div class="row">
                <div class="col-md-4 col-12">
                    <label>{{__('messages.company.zip_code')}}:
                        <span class="required asterisk-size">*</span></label>
                    {{ Form::text('mailing_zipCode', $mailingPostcode ? $mailingPostcode->postal_code : null, ['id'=> 'mailingZipCode', 'class' => 'form-control','required']) }}

                </div>
                <div class="col-md-8 col-12">

                    <label>{{__('messages.company.city')}}:
                        <span class="required asterisk-size">*</span>
                    </label>
                    {{ Form::text('mailing_city', $mailingCity ? $mailingCity->name : null, ['id'=> 'mailingCity', 'class' => 'form-control','required']) }}
                    <div class="form-tooltip">{{__('messages.company.city_tooltip')}}.</div>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-md-9 ">
            <label>{{__('messages.company.street')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('mailing_street', $company ? $company->mailing_street : null, ['id'=> 'mailing_street', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-xs-12 col-md-3 ">
            <label>{{__('messages.company.house_number')}}:
                <span class="required asterisk-size">*</span></label>
            {{ Form::text('mailing_houseNumber', $company ? $company->mailing_address : null, ['id'=> 'mailing_houseNumber', 'class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-12">
            <div class="row">
                <div class="col-md-6">
                    <label>{{__('messages.company.floor')}}:</label>
                    {{ Form::text('mailing_floor', $company ? $company->mailing_floor : null, ['id'=> 'mailing_floor', 'class' => 'form-control','required']) }}
                </div>
                <div class="col-md-6">
                    <label>{{__('messages.company.door')}}:</label>
                    {{ Form::text('mailing_door', $company ? $company->mailing_door : null, ['id'=> 'mailing_door', 'class' => 'form-control','required']) }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.company_details')}}</div>
<div class="form-group col-xl-12 col-md-12 col-sm-12">
    <div class="job-requirements-wrapper">
        <div class="job-requirements-header d-flex justify-content-between">
            <div class="job-requirements-label">
                {{ __('messages.company.videos').':' }}
            </div>
            <button id="addVideo" class="btn btn-primary">{{ __('messages.company.add_video') }}</button>
        </div>
        <div class="company-video-list">

            <div id="companyVideoPlaceholder" class="@if($company->companyVideos()->get()->count())hide-block @endif job-requirements-placeholder">{{ __('messages.company.video_placeholder') }}</div>
            <div class="accordion @if($company->companyVideos()->get()->count()) show-block @endif" id="companyVideos">
                <?php
                use App\Models\Company;use Spatie\MediaLibrary\MediaCollections\Models\Media;
                /** @var Company $company */
                if($company->companyVideos()->get()){
                    $i = 0;
                    foreach($company->companyVideos()->get() as $objCompanyVideo){
                        echo view('companies.video_layout', ['data' => $objCompanyVideo->getFormattedData(), 'videoNum' => $i+1, 'iterator' => $i])->render();
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row form-group col-xl-12 col-md-12 col-sm-12">
    <div class="col-12"><h4>{{__('messages.company.websites')}}</h4></div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('website', __('messages.company.website').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fa fa-link linkedin-fa-icon"></i>
                </div>
            </div>
            {{ Form::text('website', $company->website ?? null, ['class' => 'form-control','id'=>'website','placeholder'=>'']) }}
        </div>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('facebook_url', __('messages.company.facebook_url').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fab fa-facebook-f facebook-fa-icon"></i>
                </div>
            </div>
            {{ Form::text('facebook_url', $company->facebook_url ?? null, ['class' => 'form-control','id'=>'facebookUrl','placeholder'=>'']) }}
        </div>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('google_plus_url', __('messages.company.google_plus_url').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fab fa-google-plus-g google-plus-fa-icon"></i>
                </div>
            </div>
            {{ Form::text('google_plus_url', $company->google_plus_url ?? null, ['class' => 'form-control','id'=>'googlePlusUrl','placeholder'=>'']) }}
        </div>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('linkedin_url', __('messages.company.linkedin_url').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fab fa-linkedin-in linkedin-fa-icon"></i>
                </div>
            </div>
            {{ Form::text('linkedin_url', $company->linkedin_url ?? null, ['class' => 'form-control','id'=>'linkedInUrl','placeholder'=>'']) }}
        </div>
    </div>
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-12"><h4>{{__('messages.company.other_details')}}</h4></div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('company_size', __('messages.company.company_size').':') }}<span class="text-danger">*</span>
                {{ Form::number('company_size', $company->company_size ?? null, ['class' => 'form-control','id'=>'company_size','placeholder'=>'']) }}
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('established_in', __('messages.company.established_in').':') }}<span class="text-danger">*</span>
                {{ Form::number('established_in', $company->established_in ?? null, ['class' => 'form-control','id'=>'established_in','placeholder'=>'']) }}
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('industry_id', __('messages.company.industry').':') }}<span class="text-danger">*</span>
                <div class="input-group">
                    {{ Form::select('industry_id', $data['industries'],null, ['id'=>'industryId','class' => 'form-control','placeholder' => __('messages.company.selectIndustry'),'required']) }}
                    <div class="input-group-append plus-icon-height">
                        <div class="input-group-text">
                            <a href="javascript:void(0)" class="addIndustryModal"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        <div class="job-requirements-wrapper">
            <div class="job-requirements-header d-flex justify-content-between">
                <div class="job-requirements-label">
                    {{ __('messages.company.company_sites').':' }}
                </div>
                <button id="addSite" class="btn btn-primary">{{ __('messages.company.add_company_site') }}</button>
            </div>
            <div class="company-site-list">
                <div id="companySitePlaceholder" class="@if($company->companySites()->get()->count())hide-block @endif job-requirements-placeholder">{{ __('messages.company.company_site_placeholder') }}</div>
                <div id="companySites" class="@if($company->companySites()->get()->count()) show-block @endif">
                    <?php
                    /** @var Company $company */
                    if($company->companySites()->get()){
                        $i = 0;
                        foreach($company->companySites()->get() as $objCompanySite){
                            echo view('companies.site_layout', ['data' => $objCompanySite->getFormattedData(), 'iterator' => $i])->render();
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.introduction_and_mission')}}</div>
<div class="row">
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        {{ Form::label('introduction', __('messages.company.introduction').':') }}<span class="text-danger">*</span>
        {{ Form::textarea('introduction', $company->introduction ?? null, ['class' => 'mumi-textarea form-control' , 'id' => 'introduction', 'rows' => '10', 'required' => true]) }}
    </div>
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        {{ Form::label('mission', __('messages.company.mission').':') }}<span class="text-danger">*</span>
        {{ Form::textarea('mission', $company->mission ?? null, ['class' => 'mumi-textarea form-control' , 'id' => 'mission', 'rows' => '10', 'required' => true]) }}
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.why_work_with_us')}}</div>
<div class="row">
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        {{ Form::label('why_work_with_us', __('messages.company.why_work_with_us').':') }}<span class="text-danger">*</span>
        {{ Form::textarea('why_work_with_us', $company->why_work_with_us ?? null, ['class' => 'mumi-textarea form-control' , 'id' => 'why_work_with_us', 'rows' => '10', 'required' => true]) }}
    </div>
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="px-3">
                {{ Form::label('workplace_img', __('messages.company.workplace_img').':') }}
                <i class="fas fa-question-circle ml-1 mt-1 general-question-mark" data-toggle="tooltip"
                   data-placement="top" title="{{__('messages.company.workplace_img_tooltip')}}"></i><br/>
                <label for="workplace_img" class="image__file-upload"> {{ __('messages.setting.choose') }}</label>
            </div>
            <div class="w-auto pl-3 mt-1">
                <img class="img-thumbnail thumbnail-preview" src="{{($company->getWorkplaceImage()) ? $company->getWorkplaceImage() : asset('assets/img/placeholder.png')}}">
            </div>
            <div class="col-12">
                {{ Form::file('workplace_img',['id'=>'workplace_img','class' => 'image-uploader']) }}
            </div>
        </div>
    </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.gallery')}}</div>
<div class="row">
    <div class="col-12">
        <div class="form-group col-xl-12 col-md-12 col-sm-12">
            <div class="job-requirements-wrapper">
                <div class="job-requirements-header d-flex justify-content-between">
                    <div class="job-requirements-label">
                        {{ __('messages.company.company_gallery').':' }}
                    </div>
                    <button id="addGallery" class="btn btn-primary">{{ __('messages.company.add_company_image') }}</button>
                </div>
                <div class="company-award-list">
                    <div id="companyGalleryPlaceholder" class="@if($company->getCompanyGallery()->count())hide-block @endif job-requirements-placeholder">{{ __('messages.company.company_gallery_placeholder') }}</div>
                    <div id="companyGalleries" class="@if($company->getCompanyGallery()->count()) show-block @endif row">
                        <?php
                        /** @var Company $company */
                        /** @var Media $objMedia */
                        if($company->getCompanyGallery()){
                            $i = 0;
                            foreach($company->getCompanyGallery() as $objMedia){
                                echo view('companies.gallery_layout', ['data' => ['image' => $objMedia->getUrl(), 'mediaId' => $objMedia->id], 'iterator' => $i, 'isEdit' => true])->render();
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="form-group col-12 block_title">{{__('messages.company.awards')}}</div>
<div class="form-group col-xl-12 col-md-12 col-sm-12">
    <div class="job-requirements-wrapper">
        <div class="job-requirements-header d-flex justify-content-between">
            <div class="job-requirements-label">
                {{ __('messages.company.company_awards').':' }}
            </div>
            <button id="addAward" class="btn btn-primary">{{ __('messages.company.add_company_award') }}</button>
        </div>
        <div class="company-award-list">
            <div id="companyAwardPlaceholder" class="@if($company->companyAwards()->get()->count())hide-block @endif job-requirements-placeholder">{{ __('messages.company.company_award_placeholder') }}</div>
            <div id="companyAwards" class="@if($company->companyAwards()->get()->count()) show-block @endif">
                <?php
                /** @var Company $company */
                if($company->companyAwards()->get()){
                    $i = 0;
                    foreach($company->companyAwards()->get() as $objCompanyAward){
                        echo view('companies.award_layout', ['data' => $objCompanyAward->getFormattedData(), 'iterator' => $i, 'isEdit' => true])->render();
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="">
    {{ Form::hidden('user_id',$user->id) }}
    {{ Form::hidden('company_id',$user->company->id) }}

    <!-- Submit Field -->
    <div class="col-sm-12">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary', 'id' => 'submitCompanyForm']) }}
        <a href="{{ route('company.index') }}" class="btn btn-secondary text-dark">{{__('messages.common.cancel')}}</a>
    </div>

</div>
