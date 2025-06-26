<?php
/**
 * @var $objCandidateExtraQualifications \App\Models\CandidateExtraQualifications
 * @var $candidate \App\Models\Candidate
 */

?>

@extends('candidates.profile.index')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('section')
    <div class="card">
        <div class="card-body">

            {{ Form::open(['route' => 'update-candidate-profile', 'files' => true,'id'=>'update-candidate-profile']) }}
            <div class="alert alert-danger d-none" id="validationErrors"></div>
            {{ Form::hidden('user_id',$user->id,['id'=>'user_id']) }}
            {{ Form::hidden('candidate_id',$candidate->id,['id'=>'candidate_id']) }}
            <div class="row">

                <div class="form-group col-12 block_title">
                    Fotó
                </div>

                <div class="form-group col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-xl-12 col-12 text-center">
                            <img id='profilePreview' class="img-thumbnail thumbnail-preview"
                                 src="{{ (!empty($user->media[0])) ? $user->media[0]->getFullUrl() : asset('assets/img/main-logo.png') }}">

                            <label style="margin: auto;" class="image__file-upload text-white"> {{ __('messages.common.choose') }}
                                {{ Form::file('image',['id'=>'profile','class' => 'd-none']) }}
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group col-12 block_title">
                    Személyes Adatok
                </div>

                <div class="form-group col-sm-6">
                    {{ Form::label('last_name',__('messages.candidate.last_name').':', []) }}
                    <span class="text-danger">*</span>
                    {{ Form::text('last_name', $user->last_name, ['class' => 'form-control','required']) }}
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('first_name',__('messages.candidate.first_name').':', []) }}
                    <span class="text-danger">*</span>
                    {{ Form::text('first_name', $user->first_name, ['class' => 'form-control','required']) }}
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('email',__('messages.candidate.email').':', []) }}<span
                        class="text-danger">*</span>
                    <input class="form-control" required="" autocomplete="new-password"  name="email" type="text" value="<?=$user->email?>" id="email">
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('gender', __('messages.candidate.gender').':', []) }}<span
                        class="text-danger">*</span>
                    <div class="form-group mb-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="male" name="gender" class="custom-control-input" value="0"
                                   {{ isset($user->gender) ? ($user->gender == 0 ? 'checked' : '') : '' }} required>
                            <label class="custom-control-label" for="male">{{ __('messages.common.male') }}</label>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="female" name="gender" class="custom-control-input" value="1"
                                {{ isset($user->gender) ? ($user->gender == 1 ? 'checked' : '') : '' }}>
                            <label class="custom-control-label" for="female">{{ __('messages.common.female') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-6 custom-candidate-datepicker">
                    {{ Form::label('dob', __('messages.candidate.birth_date').':', []) }}
                    {{ Form::text('dob', $user->dob, ['class' => 'form-control','id' => 'birthDate','autocomplete' => 'off']) }}
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('marital_status', __('messages.candidate.marital_status').':', []) }}
                    <span
                        class="text-danger">*</span>
                    {{ Form::select('marital_status_id', $data['maritalStatus'], isset($user->candidate->marital_status_id) ? $user->candidate->marital_status_id : null, ['class' => 'form-control','required','id' => 'maritalStatusId','placeholder'=>__('messages.candidate.marital_status')]) }}
                </div>


                <div class="form-group col-sm-6">
                    {{ Form::label('nationality', __('messages.candidate.nationality').':', []) }}
                    {{ Form::text('nationality', isset($user->candidate->nationality) ? $user->candidate->nationality : null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('phone', __('messages.candidate.phone').':', []) }}<span
                        class="text-danger">*</span>
                    {{ Form::number('phone', isset($user->phone) ? $user->phone : null, ['class' => 'form-control','id'=>'phone']) }}
                    {{ Form::hidden('region_code',null,['id'=>'prefix_code']) }}

                    <br>
                    <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
                    <span id="error-msg" class="hide"></span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2 col-12">
                    <label>Irányítószám:
                        <span class="required asterisk-size">*</span></label>
                    <input autocomplete="off" value="<?=$objPostCode?$objPostCode->postal_code:""?>" type="text" name="zipCode"
                           id="zipCode"
                           class="form-control" required>
                </div>
                <div class="form-group col-md-4 col-12">

                    <label>Település:
                        <span class="required asterisk-size">*</span>
                    </label>
                    <input autocomplete="off" type="text" value="<?=$objCity?$objCity->name:""?>" name="city" id="city"
                           class="form-control"
                           required>
                </div>

                <div class="form-group col-md-6 col-12">
                    <label>Cím:
                        <span class="required asterisk-size">*</span>
                    </label>
                    <input autocomplete="off" type="text" value="<?=$candidate?$candidate->address:""?>" name="address" id="address"
                           class="form-control" required>
                </div>

            </div>

            <div class="form-group col-12 block_title">
                Álláskeresési adatok
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    {{ Form::label('jobCategoryId', __('messages.candidate.job_category').':') }}
                    <span
                        class="text-danger">*</span>
                    {{Form::select('candidateJobCategories[]',$data['jobCategories'], (count($candidateJobCategories) > 0) ? $candidateJobCategories : null, ['class' => 'form-control','id'=>'jobCategoryId','multiple'=>true,'required'])}}
                </div>

                <div class="form-group col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('expected_salary', __('messages.candidate.expected_salary_from').':') }}
                            {{ Form::number('expected_salary',  $candidate->expected_salary, ['class' => 'form-control']) }}
                        </div>

                        <div class="col-sm-6">
                            {{ Form::label('expected_salary_to', __('messages.candidate.expected_salary_to').':') }}
                            {{ Form::number('expected_salary_to',  $candidate->expected_salary_to, ['class' => 'form-control ']) }}
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6">
                    {{ Form::label('jobShiftId', __('messages.candidate.job_shift').':', []) }}
                    <span
                        class="text-danger">*</span>
                    {{Form::select('candidateJobShifts[]',$data['jobShifts'], (count($candidateJobShifts) > 0) ? $candidateJobShifts : null, ['class' => 'form-control','id'=>'jobShiftId','multiple'=>true,'required'])}}
                </div>


                <div class="form-group col-sm-6">
                    {{ Form::label('jobTypeId', __('messages.job.job_types').':', []) }}
                    <span
                        class="text-danger">*</span>
                    {{Form::select('candidateJobTypes[]',$data['jobTypes'], (count($candidateJobType) > 0) ? $candidateJobType : null, ['class' => 'form-control','id'=>'jobTypeId','multiple'=>true,'required'])}}
                </div>

                <div class="form-group col-sm-12">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {{ Form::label('able_to_travel_distance', __('messages.candidate.able_to_travel_km').':') }}
                            {{ Form::number('able_to_travel_distance',  $candidate->travel_max_distance, ['class' => 'form-control', 'type'=>'number']) }}
                        </div>
                        <div class="form-group col-sm-6">
                            {{ Form::label('able_to_travel_city_id', __('messages.candidate.able_to_travel_cities').':') }}

                            <div class="input-group">
                                {{Form::select('candidateAbleToTravelCities[]',$data['cities'], (count($candidateAbleToTravel) > 0) ? $candidateAbleToTravel : null, ['class' => 'form-control','id'=>'ableToTravelCityId','multiple'=>true])}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-6">
                    <label>{{ __('messages.candidate.able_to_move_anywhere').':' }}</label><br>
                    <label class="custom-switch pl-0">
                        <input type="checkbox" name="able_to_move_anywhere" class="custom-switch-input isActive"
                               value="1" id="able_to_move_anywhere" {{ $candidate->move_anywhere?"checked":"" }}>
                        <span class="custom-switch-indicator"></span>
                    </label>

                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('able_to_move_city_id', __('messages.candidate.able_to_move_cities').':') }}

                    <div class="input-group">
                        {{Form::select('candidateAbleToMoveCities[]',$data['cities'],(count($candidateAbleToMove) > 0) ? $candidateAbleToMove : null , ['class' => 'form-control','id'=>'ableToMoveCityId','multiple'=>true])}}
                    </div>
                </div>


                <div class="form-group col-sm-6">
                    {{ Form::label('circumstances_id', __('messages.candidate.circumstances').':') }}

                    <div class="input-group">
                        {{Form::select('candidateCircumstances[]',$data['circumstances'], (count($candidateCircumstances) > 0) ? $candidateCircumstances : null, ['class' => 'form-control','id'=>'circumstancesId','multiple'=>true])}}
                    </div>
                </div>

                <div class="form-group col-12 block_title">
                    Kompetenciák
                </div>

                <div class="form-group col-sm-12 main_level">

                    <div class="row lang_rows" id="lang_row">

                        <tocopy class="soft-hidden">
                            <div class="row lang_rows">

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
                                            <a href="javascript:void(0)" class="addExtraLangRow"><i
                                                    class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-1 soft-hidden button_minus">
                                    <div class="input-group-append plus-icon-height empty_label_space">
                                        <div class="input-group-text">
                                            <a href="javascript:void(0)" class="removeExtraLangRow"><i
                                                    class="fa fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </tocopy>

                        <div class="form-group col-sm-5">
                            {{ Form::label('language_id', __('messages.candidate.candidate_language').':') }}
                            <div class="input-group">
                                {{Form::select('candidateLanguage[]',$data['language'], isset($candidateLanguage[0])?$candidateLanguage[0]["language_id"]:null, ['class' => 'form-control','id'=>'languageId','multiple'=>false,'required'])}}
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('language_level_id', __('messages.candidate.candidate_language_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateLanguageLevel[]',$data['language_level'], isset($candidateLanguage[0])?$candidateLanguage[0]["language_level_id"]:null, ['class' => 'form-control','id'=>'languageLevelId','multiple'=>false,'required'])}}
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

                    <?php
                    foreach ($candidateLanguage as $key => $arrData) {
                    if ($key == 0) {
                        continue;
                    }
                    ?>

                    <div class="row lang_rows" counter="0">

                        <div class="form-group col-sm-5">
                            {{ Form::label('language_id', __('messages.candidate.candidate_language').':') }}

                            <div class="input-group">
                                {{Form::select('candidateLanguage[]',$data['language'], $arrData["language_id"], ['class' => 'form-control','id'=>'','multiple'=>false,'required'])}}
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('language_level_id', __('messages.candidate.candidate_language_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateLanguageLevel[]',$data['language_level'], $arrData["language_level_id"], ['class' => 'form-control select2base','id'=>'','multiple'=>false,'required'])}}
                            </div>
                        </div>

                        <div class="form-group col-sm-1 button_minus">
                            <div class="input-group-append plus-icon-height empty_label_space">
                                <div class="input-group-text">
                                    <a href="javascript:void(0)" class="removeExtraLangRow"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
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
                            {{ Form::text('basic_it_skills[]',  isset($candidateBasicSkills[0])?$candidateBasicSkills[0]["skill"]:null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateBasicItSkillLevel[]',$data['skill_level'],  isset($candidateBasicSkills[0])?$candidateBasicSkills[0]["skill_level_id"]:null, ['class' => 'form-control','id'=>'SkillLevelId','multiple'=>false,'required'])}}
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

                    <?php
                    foreach ($candidateBasicSkills as $key => $arrData) {
                    if ($key == 0) {
                        continue;
                    }
                    ?>
                    <div class="row basic_skills_rows" counter="0">

                        <div class="form-group col-sm-5">
                            {{ Form::label('basic_it_skills',__('messages.candidate.basic_it_skill').':') }}
                            {{ Form::text('basic_it_skills[]', $arrData["skill"], ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateBasicItSkillLevel[]',$data['skill_level'], $arrData["skill_level_id"], ['class' => 'form-control select2base','id'=>'','multiple'=>false,'required'])}}
                            </div>
                        </div>

                        <div class="form-group col-sm-1 button_minus">
                            <div class="input-group-append plus-icon-height empty_label_space">
                                <div class="input-group-text">
                                    <a href="javascript:void(0)" class="removeExtraBasicSkillRow"><i
                                            class="fa fa-minus"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                    }
                    ?>

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
                            {{ Form::text('advanced_it_skills[]', isset($candidateAdvancedSkills[0])?$candidateAdvancedSkills[0]["skill"]:null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateAdvancedItSkillLevel[]',$data['skill_level'], isset($candidateAdvancedSkills[0])?$candidateAdvancedSkills[0]["skill_level_id"]:null, ['class' => 'form-control','id'=>'SkillLevelId2','multiple'=>false,'required'])}}
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

                    <?php
                    foreach ($candidateAdvancedSkills as $key => $arrData) {
                    if ($key == 0) {
                        continue;
                    }
                    ?>
                    <div class="row advanced_skill_rows" counter="0">

                        <div class="form-group col-sm-5">
                            {{ Form::label('advanced_it_skills',__('messages.candidate.advanced_it_skill').':') }}
                            {{ Form::text('advanced_it_skills[]', $arrData["skill"], ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateAdvancedItSkillLevel[]',$data['skill_level'], $arrData["skill_level_id"], ['class' => 'form-control select2base','id'=>'','multiple'=>false,'required'])}}
                            </div>
                        </div>

                        <div class="form-group col-sm-1 button_minus">
                            <div class="input-group-append plus-icon-height empty_label_space">
                                <div class="input-group-text">
                                    <a href="javascript:void(0)" class="removeExtraAdvancedSkillRow"><i
                                            class="fa fa-minus"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                    }

                    ?>
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
                            {{ Form::text('software_skills[]', isset($candidateSoftwareSkills[0])?$candidateSoftwareSkills[0]["skill"]:null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateSoftwareSkillLevel[]',$data['skill_level'], isset($candidateSoftwareSkills[0])?$candidateSoftwareSkills[0]["skill"]:null, ['class' => 'form-control','id'=>'SkillLevelId3','multiple'=>false,'required'])}}
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

                    <?php
                    foreach ($candidateSoftwareSkills as $key => $arrData) {
                    if ($key == 0) {
                        continue;
                    }
                    ?>
                    <div class="row software_skill_rows" counter="0">
                        <div class="form-group col-sm-5">
                            {{ Form::label('software_skills',__('messages.candidate.software_skill').':') }}
                            {{ Form::text('software_skills[]', $arrData["skill"], ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_level_id', __('messages.candidate.candidate_skill_level').':') }}
                            <div class="input-group">
                                {{Form::select('candidateSoftwareSkillLevel[]',$data['skill_level'], $arrData["skill_level_id"], ['class' => 'form-control select2base','id'=>'','multiple'=>false,'required'])}}
                            </div>
                        </div>
                        <div class="form-group col-sm-1 button_minus">
                            <div class="input-group-append plus-icon-height empty_label_space">
                                <div class="input-group-text">
                                    <a href="javascript:void(0)" class="removeExtraSoftwareSkillRow"><i
                                            class="fa fa-minus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }

                    ?>
                    <div class="form-group col-12">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {{ Form::label('driving_licence_id', __('messages.candidate.driving_licence').':') }}
                            <div class="input-group">
                                {{Form::select('candidateDrivingLicence[]',$data['driving_lincences'], (count($candidateDrivingLicences) > 0)?$candidateDrivingLicences:null, ['class' => 'form-control','id'=>'drivingLicenceId','multiple'=>true,'required'])}}
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            {{ Form::label('skill_id', __('messages.candidate.candidate_skill').':') }}
                            <div class="input-group unsetflexwrap">
                                {{Form::select('candidateSkills[]',$data['skills'], (count($candidateSkills) > 0)?$candidateSkills:null, ['class' => 'form-control','id'=>'skillId','multiple'=>true,'required'])}}
                                <div class="input-group-append plus-icon-height">
                                    <div class="input-group-text">
                                        <a href="javascript:void(0)" class="addSkillModal"><i
                                                class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    {{ Form::label('hobbies',__('messages.candidate.hobbies').':') }}
                                    {{ Form::textarea('hobbies', $objCandidateExtraQualifications?$objCandidateExtraQualifications->getHobbies():null, ['class' => 'form-control', 'style'=>'height:100px','rows' => 4]) }}
                                </div>
                                <div class="form-group col-sm-6">
                                    {{ Form::label('other_comments',__('messages.candidate.other_comments').':') }}
                                    {{ Form::textarea('other_comments',  $objCandidateExtraQualifications?$objCandidateExtraQualifications->getOtherComments():null, ['class' => 'form-control', 'style'=>'height:100px', 'rows' => 4]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12 block_title">
                    Extra igények
                </div>

                <div class="form-group col-sm-6">
                    {{ Form::label('extra_requirements_id', __('messages.candidate.extra_requirements').':') }}
                    <div class="input-group">
                        {{Form::select('candidateExtraRequirements[]',$data['extra_requirements'], count($candidateExtraRequirements)?$candidateExtraRequirements:null, ['class' => 'form-control','id'=>'candidateExtraRequirementId','multiple'=>true])}}
                    </div>
                </div>

                <div class="form-group col-12 block_title">
                    Státusz
                </div>
                <div class="form-group col-sm-6">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {{ Form::label('immediate_available', __('messages.candidate.immediate_available').':', []) }}
                            <div class="form-group mb-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="available" name="immediate_available" class="custom-control-input"
                                           value="1"
                                        {{ isset($user->candidate->immediate_available) ? ($user->candidate->immediate_available == 1 ? 'checked' : '') : 'checked' }}>
                                    <label class="custom-control-label"
                                           for="available">{{ __('messages.candidate.immediate_available') }}</label>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="not_available" name="immediate_available"
                                           class="custom-control-input"
                                           value="0"
                                        {{ isset($user->candidate->immediate_available) ? ($user->candidate->immediate_available == 0 ? 'checked' : '') : '' }}>
                                    <label class="custom-control-label"
                                           for="not_available">{{ __('messages.candidate.not_immediate_available') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 available-at">
                            {{ Form::label('available_at', __('messages.candidate.available_at').':', []) }}
                            {{ Form::text('available_at', isset($user->candidate->available_at) ? $user->candidate->available_at : null, ['class' => 'form-control','id' => 'availableAt','autocomplete' => 'off']) }}
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12 mb-0 pt-1">
                            <label>Regisztráció státusza</label><br>
                            <label class="custom-switch pl-0">
                                <input type="checkbox" name="is_active" class="custom-switch-input isActive"
                                       value="1" id="active" {{ $user->is_active?"checked":"" }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-8 col-sm-12 mb-0 pt-1">
                            <label>{{ __('messages.candidate.is_verified').':' }}</label><br>
                            <label class="custom-switch pl-0">
                                <input type="checkbox" name="is_verified" class="custom-switch-input"
                                       value="1" id="verified" {{ $user->is_verified?"checked":"" }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                </div>



                <div class="form-group col-sm-6">
                    {{ Form::label('status_id', __('messages.candidate.status').':') }}
                    <span class="text-danger">*</span>
                    <div class="input-group">
                        {{Form::select('candidate_status_id',$data['statuses'], $candidate->candidate_status_id, ['class' => 'form-control','id'=>'statusId','multiple'=>false,'required'])}}
                    </div>
                </div>


                <div class="form-group col-12 block_title">
                    Közösségi Elérhetőségek
                </div>

                <div class="form-group col-xl-6 col-md-6 col-sm-12">
                    {{ Form::label('linkedin_url', __('messages.company.linkedin_url').':', []) }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fab fa-linkedin-in linkedin-fa-icon"></i>
                            </div>
                        </div>
                        {{ Form::text('linkedin_url', $user->linkedin_url, ['class' => 'form-control','id'=>'linkedInUrl','placeholder'=>'https://www.linkedin.com']) }}
                    </div>
                </div>
                <div class="form-group col-xl-6 col-md-6 col-sm-12">
                    {{ Form::label('facebook_url', __('messages.company.facebook_url').':', []) }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fab fa-facebook-f facebook-fa-icon"></i>
                            </div>
                        </div>
                        {{ Form::text('facebook_url',$user->facebook_url, ['class' => 'form-control','id'=>'facebookUrl','placeholder'=>'https://www.facebook.com']) }}
                    </div>
                </div>
                <div class="form-group col-xl-6 col-md-6 col-sm-12">
                    {{ Form::label('twitter_url', __('messages.company.twitter_url').':', []) }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fab fa-twitter twitter-fa-icon"></i>
                            </div>
                        </div>
                        {{ Form::text('twitter_url', $user->twitter_url , ['class' => 'form-control','id'=>'twitterUrl','placeholder'=>'https://www.twitter.com']) }}
                    </div>
                </div>

                <div class="form-group col-xl-6 col-md-6 col-sm-12">
                    {{ Form::label('google_plus_url', __('messages.company.google_plus_url').':', []) }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fab fa-google-plus-g google-plus-fa-icon"></i>
                            </div>
                        </div>
                        {{ Form::text('google_plus_url', $user->google_plus_url, ['class' => 'form-control','id'=>'googlePlusUrl','placeholder'=>'https://www.plus.google.com']) }}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Submit Field -->
                <div class="form-group col-sm-6">
                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary btnSave']) }}
                    <a href="" class="btn btn-secondary hover-text-dark text-dark">Cancel</a>
                </div>
                <div class="form-group col-sm-6 text-right pull-right">
                    <a href="javascript:void(0)"
                       class="btn btn-warning generate_resume">{{__('messages.common.create-cv')}}</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
<script>
    let countryId = '{{$user->country_id}}';
    let stateId = '{{$user->state_id}}';
    let cityId = '{{$user->city_id}}';
    let isEdit = true;
    let phoneNo = "{{ old('region_code').old('phone') }}";
    //let utilsScript = "{{asset('assets/js/inttel/js/utils.min.js')}}";
</script>
@push('page-scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCandidateRequest') !!}
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('assets/js/custom/input_price_format.js')}}"></script>
    <script src="{{asset('assets/js/candidate-profile/candidate-general.js')}}"></script>
    <script src="{{ asset('assets/js/inttel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/inttel/js/utils.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/phone-number-country-code.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            resetJsValidation("update-candidate-profile");

        });
    </script>
@endpush
