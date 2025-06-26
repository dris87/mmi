<div class="row">

    <div class="form-group col-12 block_title">
        Fotó
    </div>

    <div class="form-group col-sm-12">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12 col-xl-12 col-12 text-center">
                <img id='profilePreview' class="img-thumbnail thumbnail-preview"
                     src="{{ asset('assets/img/main-logo.png') }}">

                <label style="margin: auto;" class="image__file-upload text-white"> {{ __('messages.common.choose') }}
                    {{ Form::file('image',['id'=>'profile','class' => 'd-none']) }}
                </label>
            </div>

        </div>
    </div>

    <div class="form-group col-12 block_title" >
        Személyes Adatok
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('last_name',__('messages.candidate.last_name').':') }}<span class="text-danger">*</span>
        {{ Form::text('last_name', null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('first_name',__('messages.candidate.first_name').':') }}<span class="text-danger">*</span>
        {{ Form::text('first_name', null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('email',__('messages.candidate.email').':') }}<span class="text-danger">*</span>
        <input class="form-control" required="" autocomplete="new-password" name="email" type="email" id="email">
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('gender', __('messages.candidate.gender').':') }}<span class="text-danger">*</span><br>
        {{ Form::radio('gender', '0', true) }} {{ __('messages.common.male') }} &nbsp;&nbsp;&nbsp;
        {{ Form::radio('gender', '1') }} {{ __('messages.common.female') }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('password',__('messages.candidate.password').':') }}<span class="text-danger">*</span>
        {{ Form::password('password', ['class' => 'form-control','required','min' => '6','max' => '10','autocomplete'=>'new-password']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('password_confirmation',__('messages.candidate.conform_password').':') }}<span
            class="text-danger">*</span>
        {{ Form::password('password_confirmation', ['class' => 'form-control','required','min' => '6','max' => '10']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('dob', __('messages.candidate.birth_date').':') }}
        {{ Form::text('dob', null, ['class' => 'form-control','id' => 'birthDate','autocomplete' => 'off']) }}
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('marital_status', __('messages.candidate.marital_status').':') }}<span
            class="text-danger">*</span>
        <div class="input-group">
            {{ Form::select('marital_status_id', $data['maritalStatus'], null, ['class' => 'form-control','required','id' => 'maritalStatusId','placeholder'=> __('messages.candidate.select_marital_status')]) }}
            <div class="input-group-append plus-icon-height">
                <div class="input-group-text">
                    <a href="javascript:void(0)" class="addMaritalStatusModal"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('nationality', __('messages.candidate.nationality').':') }}
        {{ Form::text('nationality', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('phone', __('messages.candidate.phone').':') }}<span class="text-danger">*</span>
        {{ Form::number('phone', null, ['id'=>'phone','class' => 'form-control'])}}
        {{ Form::hidden('region_code',null,['id'=>'prefix_code']) }}
        <br>
        <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
        <span id="error-msg" class="hide"></span>
    </div>


    <div class="form-group col-12">
        <div class="row">
            <div class="form-group col-md-2 col-12">
                {{ Form::label('zipCode',__('messages.candidate.postal_code').':') }}<span class="text-danger">*</span>
                {{ Form::text('zipCode', null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('city',__('messages.candidate.city').':') }}<span class="text-danger">*</span>
                {{ Form::text('city', null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-md-6 col-12">
                {{ Form::label('address',__('messages.candidate.address').':') }}<span class="text-danger">*</span>
                {{ Form::text('address', null, ['class' => 'form-control','required']) }}
            </div>
        </div>
    </div>

    <div class="form-group col-12 block_title" >
        Álláskeresési adatok
    </div>


    <div class="form-group col-sm-6">
        {{ Form::label('jobCategoryId', __('messages.candidate.job_category').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{Form::select('candidateJobCategories[]',$data['jobCategories'], null, ['class' => 'form-control','id'=>'jobCategoryId','multiple'=>true,'required'])}}
            <div class="input-group-append plus-icon-height">
                <div class="input-group-text">
                    <a href="javascript:void(0)" class="addJobCategoryModal"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>


    <div class= "form-group col-sm-5">
        <div class="row">
            <div class="col-sm-6">
                {{ Form::label('expected_salary', __('messages.candidate.expected_salary_from').':') }}
                {{ Form::number('expected_salary',  null, ['class' => 'form-control ']) }}
            </div>

            <div class="col-sm-6">
                {{ Form::label('expected_salary_to', __('messages.candidate.expected_salary_to').':') }}
                {{ Form::number('expected_salary_to',  null, ['class' => 'form-control ']) }}
            </div>
        </div>


    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('jobShiftId', __('messages.candidate.job_shift').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{Form::select('candidateJobShifts[]',$data['jobShifts'], null, ['class' => 'form-control','id'=>'jobShiftId','multiple'=>true,'required'])}}
            <div class="input-group-append plus-icon-height">
                <div class="input-group-text">
                    <a href="javascript:void(0)" class="addJobShiftModal"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('jobTypeId', __('messages.job.job_types').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{Form::select('candidatejobTypes[]',$data['jobTypes'], null, ['class' => 'form-control','id'=>'jobTypeId','multiple'=>true,'required'])}}
            <div class="input-group-append plus-icon-height">
                <div class="input-group-text">
                    <a href="javascript:void(0)" class="addJobTypeModal"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-sm-12">
        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('able_to_travel_distance', __('messages.candidate.able_to_travel_km').':') }}
                {{ Form::number('able_to_travel_distance', null, ['class' => 'form-control', 'type'=>'number']) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('able_to_travel_city_id', __('messages.candidate.able_to_travel_cities').':') }}

                <div class="input-group">
                    {{Form::select('candidateAbleToTravelCities[]',$data['cities'], null, ['class' => 'form-control','id'=>'ableToTravelCityId','multiple'=>true])}}
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('able_to_travel_distance', __('messages.candidate.able_to_move_anywhere').':') }}
        {{ Form::checkbox('able_to_move_anywhere', null, ['class' => 'form-control', 'type'=>'number']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('able_to_move_city_id', __('messages.candidate.able_to_move_cities').':') }}

        <div class="input-group">
            {{Form::select('candidateAbleToMoveCities[]',$data['cities'], null, ['class' => 'form-control','id'=>'ableToMoveCityId','multiple'=>true])}}
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('circumstances_id', __('messages.candidate.circumstances').':') }}

        <div class="input-group">
            {{Form::select('candidateCircumstances[]',$data['circumstances'], null, ['class' => 'form-control','id'=>'circumstancesId','multiple'=>true])}}
        </div>
    </div>

    <div class="form-group col-12 block_title" >
        Kompetenciák
    </div>

    <div class="form-group col-sm-12 main_level">

        <div class="row lang_rows" id="lang_row">

            <tocopy class="soft-hidden">
                <div class="row lang_rows" counter="0">

                    <div class="form-group col-sm-5">
                        {{ Form::label('language_id', __('messages.candidate.candidate_language').':') }}

                        <div class="input-group">
                            {{Form::select('candidateLanguage[]',$data['language'], null, ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        {{ Form::label('language_level_id', __('messages.candidate.candidate_language_level').':') }}
                        <div class="input-group">
                            {{Form::select('candidateLanguageLevel[]',$data['language_level'], null, ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                        </div>
                    </div>

                    <div class="form-group col-sm-1 button_plus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="addExtraLangRow"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-1 soft-hidden button_minus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="removeExtraLangRow"><i class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </tocopy>

            <div class="form-group col-sm-5">
                {{ Form::label('language_id', __('messages.candidate.candidate_language').':') }}
                <div class="input-group">
                    {{Form::select('candidateLanguage[]',$data['language'], null, ['class' => 'form-control','id'=>'languageId','multiple'=>false,'required'])}}
                </div>
            </div>

            <div class="form-group col-sm-6">
                {{ Form::label('language_level_id', __('messages.candidate.candidate_language_level').':') }}
                <div class="input-group">
                    {{Form::select('candidateLanguageLevel[]',$data['language_level'], null, ['class' => 'form-control','id'=>'languageLevelId','multiple'=>false,'required'])}}
                </div>
            </div>

            <div class="form-group col-sm-1 button_plus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="addExtraLangRow"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-1 soft-hidden button_minus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="removeExtraLangRow"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group col-12">
            <hr>
        </div>

        <div class="row basic_skills_rows" id="basic_skill_row">

            <tocopy class="soft-hidden">
                <div class="row basic_skills_rows" counter="0">

                    <div class="form-group col-sm-5">
                        {{ Form::label('basic_it_skills',__('messages.candidate.basic_it_skill').':') }}
                        {{ Form::text('basic_it_skills[]', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-sm-6">
                        {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                        <div class="input-group">
                            {{Form::select('candidateBasicItSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                        </div>
                    </div>

                    <div class="form-group col-sm-1 button_plus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="addExtraBasicSkillRow"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-1 soft-hidden button_minus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="removeExtraBasicSkillRow"><i
                                        class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </tocopy>

            <div class="form-group col-sm-5">
                {{ Form::label('basic_it_skills',__('messages.candidate.basic_it_skill').':') }}
                {{ Form::text('basic_it_skills[]', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group col-sm-6">
                {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                <div class="input-group">
                    {{Form::select('candidateBasicItSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'SkillLevelId','multiple'=>false,'required'])}}
                </div>
            </div>

            <div class="form-group col-sm-1 button_plus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="addExtraBasicSkillRow"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-1 soft-hidden button_minus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="removeExtraBasicSkillRow"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group col-12">
            <hr>
        </div>

        <div class="row advanced_skill_rows" id="advanced_skill_row">

            <tocopy class="soft-hidden">
                <div class="row advanced_skill_rows" counter="0">

                    <div class="form-group col-sm-5">
                        {{ Form::label('advanced_it_skills',__('messages.candidate.advanced_it_skill').':') }}
                        {{ Form::text('advanced_it_skills[]', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-sm-6">
                        {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                        <div class="input-group">
                            {{Form::select('candidateAdvancedItSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                        </div>
                    </div>

                    <div class="form-group col-sm-1 button_plus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="addExtraAdvancedSkillRow"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-1 soft-hidden button_minus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="removeExtraAdvancedSkillRow"><i
                                        class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </tocopy>

            <div class="form-group col-sm-5">
                {{ Form::label('advanced_it_skills',__('messages.candidate.advanced_it_skill').':') }}
                {{ Form::text('advanced_it_skills[]', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group col-sm-6">
                {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                <div class="input-group">
                    {{Form::select('candidateAdvancedItSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'SkillLevelId2','multiple'=>false,'required'])}}
                </div>
            </div>

            <div class="form-group col-sm-1 button_plus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="addExtraAdvancedSkillRow"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-1 soft-hidden button_minus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="removeExtraAdvancedSkillRow"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group col-12">
            <hr>
        </div>

        <div class="row software_skill_rows" id="software_skill_row">

            <tocopy class="soft-hidden">
                <div class="row software_skill_rows" counter="0">

                    <div class="form-group col-sm-5">
                        {{ Form::label('software_skills',__('messages.candidate.software_skill').':') }}
                        {{ Form::text('software_skills[]', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-sm-6">
                        {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                        <div class="input-group">
                            {{Form::select('candidateSoftwareSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                        </div>
                    </div>

                    <div class="form-group col-sm-1 button_plus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="addExtraSoftwareSkillRow"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-1 soft-hidden button_minus">
                        <div class="input-group-append plus-icon-height empty_label_space">
                            <div class="input-group-text">
                                <a href="javascript:void(0)" class="removeExtraSoftwareSkillRow"><i
                                        class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </tocopy>

            <div class="form-group col-sm-5">
                {{ Form::label('software_skills',__('messages.candidate.software_skill').':') }}
                {{ Form::text('software_skills[]', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group col-sm-6">
                {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                <div class="input-group">
                    {{Form::select('candidateSoftwareSkillLevel[]',$data['skill_level'], null, ['class' => 'form-control','id'=>'SkillLevelId3','multiple'=>false,'required'])}}
                </div>
            </div>

            <div class="form-group col-sm-1 button_plus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="addExtraSoftwareSkillRow"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-1 soft-hidden button_minus">
                <div class="input-group-append plus-icon-height empty_label_space">
                    <div class="input-group-text">
                        <a href="javascript:void(0)" class="removeExtraSoftwareSkillRow"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group col-12">
            <hr>
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                {{ Form::label('driving_licence_id', __('messages.candidate.driving_licence').':') }}
                <div class="input-group">
                    {{Form::select('candidateDrivingLicence[]',$data['driving_lincences'], null, ['class' => 'form-control','id'=>'drivingLicenceId','multiple'=>true,'required'])}}
                </div>
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('skill_id', __('messages.candidate.candidate_skill').':') }}
                <div class="input-group">
                    {{Form::select('candidateSkills[]',$data['skills'], null, ['class' => 'form-control','id'=>'skillId','multiple'=>true,'required'])}}
                    <div class="input-group-append plus-icon-height">
                        <div class="input-group-text">
                            <a href="javascript:void(0)" class="addSkillModal"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="form-group col-sm-6">
                {{ Form::label('hobbies',__('messages.candidate.hobbies').':') }}
                {{ Form::textarea('hobbies', null, ['class' => 'form-control', 'style'=>'height:100px','rows' => 4]) }}
            </div>
            <div class="form-group col-sm-6">
                {{ Form::label('other_comments',__('messages.candidate.other_comments').':') }}
                {{ Form::textarea('other_comments', null, ['class' => 'form-control', 'style'=>'height:100px', 'rows' => 4]) }}
            </div>
        </div>
    </div>


    <div class="form-group col-12 block_title" >
        Extra igények
    </div>


    <div class="form-group col-sm-6">
        {{ Form::label('extra_requirements_id', __('messages.candidate.extra_requirements').':') }}
        <div class="input-group">
            {{Form::select('candidateExtraRequirements[]',$data['extra_requirements'], null, ['class' => 'form-control','id'=>'candidateExtraRequirementId','multiple'=>true])}}
        </div>
    </div>

    <div class="form-group col-12 block_title" >
        Státusz
    </div>


    <div class="form-group col-sm-6">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                {{ Form::label('immediate_available', __('messages.candidate.available_at').':') }}<span
                    class="text-danger">*</span><br>
                {{ Form::radio('immediate_available', '1', true) }} {{ __('messages.candidate.immediate_available') }}
                <br>
                {{ Form::radio('immediate_available', '0') }} {{ __('messages.candidate.not_immediate_available') }}
            </div>
            <div class="form-group col-sm-6 available-at">
                {{ Form::label('available_at', __('messages.candidate.available_at').':') }}
                {{ Form::text('available_at', null, ['class' => 'form-control', 'id' => 'availableAt','autocomplete' => 'off']) }}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12 mb-0 pt-1">
                <label>Regisztráció státusza</label><br>
                <label class="custom-switch pl-0">
                    <input type="checkbox" name="is_active" class="custom-switch-input isActive"
                           value="1" id="active" checked>
                    <span class="custom-switch-indicator"></span>
                </label>
            </div>
            <div class="custom-control custom-checkbox pl-0">
                <label>{{ __('messages.candidate.is_verified').':' }}</label><br>
                <label class="custom-switch pl-0">
                    <input type="checkbox" name="is_verified" class="custom-switch-input"
                           value="1" id="verified" checked>
                    <span class="custom-switch-indicator"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('status_id', __('messages.candidate.status').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{Form::select('candidate_status_id',$data['statuses'], \App\Models\CandidateStatus::STATUS_AKTIV, ['class' => 'form-control','id'=>'statusId','multiple'=>false,'required'])}}
        </div>
    </div>

    <div class="form-group col-sm-12 pt-4">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
        <a href="{{ route('candidates.index') }}"
           class="btn btn-secondary text-dark">{{__('messages.common.cancel')}}</a>
    </div>
</div>
