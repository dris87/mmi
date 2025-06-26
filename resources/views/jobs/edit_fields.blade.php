<input type="hidden" id="id" value="<?=$job->id?>">

<?php
if($job->status === \App\Models\Job::STATUS_PENDING){
?>
<div class="alert alert-warning" role="alert">
    A hirdetés elbírálásra vár
</div>
<?php
}
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-3 col-md-3 col-sm-12" style="    padding-top: 5px;">
                <h5 style="margin-bottom: 0;">
                    <div style="float: left">
                        Státusz :
                    </div>
                    <div style="float: left;    padding-left: 8px;">
                        <?php
                        if ($job->is_suspended) {
                            echo " " . __(
                                    "messages.job_status.Suspended"
                                ) . " <br><i style='font-size : 15px;     font-weight: 200;'>korábban : " . __(
                                    "messages.job_status." . \App\Models\Job::STATUS[$job->status]
                                ) . "</i>";
                        } else {
                            echo " " . __("messages.job_status." . \App\Models\Job::STATUS[$job->status]);
                        }
                        ?>
                    </div>
                </h5>
            </div>
            <div class="col-xl-9 col-md-9 col-sm-12 text-right">
                <?php
                if(!$job->is_suspended && ($job->status === \App\Models\Job::STATUS_PENDING || $job->status === \App\Models\Job::STATUS_APPROVED || $job->status === \App\Models\Job::STATUS_ADMIN_DECLINED)){

                if($job->status === \App\Models\Job::STATUS_PENDING || $job->status === \App\Models\Job::STATUS_ADMIN_DECLINED){
                ?>
                <button id="job_approve" class="btn btn-success">Hirdetés jóváhagyása</button>
                <?php

                }
                if($job->status === \App\Models\Job::STATUS_PENDING || $job->status === \App\Models\Job::STATUS_APPROVED){
                ?>
                <button id="job_decline" class="btn btn-danger">Hirdetés elutasítása</button>
                <?php
                }
                }

                if($job->is_suspended){
                ?>
                <button id="job_unsuspend" class="btn btn-info">Felfüggesztés feloldása</button>
                <?php
                }else{
                ?>
                <button id="job_suspend" class="btn btn-danger">Hirdetés felfüggesztése</button>
                <?php
                }


                $send_job_email = "disabled";

                if (($job->status == \App\Models\Job::STATUS_APPROVED || $job->status == \App\Models\Job::STATUS_ACTIVE) &&  $job->is_suspended == 0) {
                    $send_job_email = "";
                }

                if (($job->status == \App\Models\Job::STATUS_APPROVED || $job->status == \App\Models\Job::STATUS_ACTIVE) &&  $job->is_suspended == 0) {
                    $send_job_email = "";
                }

                if ($job->status == \App\Models\Job::STATUS_APPROVED && $job->status !== \App\Models\Job::STATUS_ACTIVE &&  $job->is_suspended == 0) {
                ?>
                    <button id="activateJob" class="btn btn-success">Hirdetés aktiválása</button>
                <?php
                }
                ?>

                <button id="sendJob" <?=$send_job_email?> class="btn btn-primary">Látványterv kiküldése</button>
            </div>
        </div>

    </div>
</div>

{{ Form::model($job, ['route' => ['admin.job.update', $job->id], 'method' => 'post', 'id' => 'editJobForm']) }}
<input type="hidden" name="redirect_url_after_update" value="{!! URL::previous() !!}">
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                {{ Form::label('job_release_date', __('messages.job.release_date').':') }} <span
                    class="text-danger">*</span>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    {{ Form::text('job_release_date', $fields["job_release_date"], ['class' => 'form-control jobReleaseDateEdit', 'required', 'autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                {{ Form::label('job_application_due_date', __('messages.job.application_due_date').':') }} <span
                    class="text-danger">*</span>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    {{ Form::text('job_expiry_date', $fields["job_expiry_date"], ['class' => 'form-control jobApplicationDueDateEdit', 'required', 'autocomplete' => 'off']) }}
                </div>
            </div>

            <div class="form-group col-xl-6 col-md-6 col-sm-12 text-right">
                <label>{{ __('messages.job.is_anonym').':' }}</label><br>
                <label class="custom-switch pl-0">
                    <input type="checkbox" name="is_anonym"
                           <?php echo $fields['is_anonym'] ? 'checked' : ''; ?> class="custom-switch-input isActive"
                           value="1" id="isAnonym">
                    <span class="custom-switch-indicator"></span>
                </label>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('job_title', __('messages.job.job_title').':') }}<span class="text-danger">*</span>
                {{ Form::text('job_title', $fields['job_title'] ?? null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('job_position', __('messages.job.job_position').':') }}<span
                    class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::text('job_position', $fields['job_position'] ?? null, ['class' => 'form-control','required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('job_locations', __('messages.job.job_location').':') }}<span
                    class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('job_locations[]', $data['cities'], $fields['job_locations'] ?? null, ['id'=>'jobLocationId','class' => 'form-control','multiple' => true, 'required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('job_shifts', __('messages.job.job_shift').':') }}<span class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('job_shifts[]', $data['jobShift'], $fields['job_shifts'] ?? null, ['id'=>'jobShiftId','class' => 'form-control','multiple' => true, 'required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('job_types', __('messages.job.job_form').':') }}<span class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('job_types', $data['jobType'], $fields['job_types'] ?? null, ['id'=>'jobTypeId','class' => 'form-control','placeholder' => '','required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('job_candidate_count', __('messages.job.job_candidate_count').':') }}<span
                    class="text-danger">*</span>
                {{ Form::text('job_candidate_count', $fields['job_candidate_count'] ?? null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('job_categories', __('messages.job_category.job_category').':') }}
                <span class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('job_categories[]', $data['jobCategory'],$fields['job_categories'] ?? null, ['id'=>'jobCategoryId','class' => 'form-control', 'multiple' => true,'required']) }}
                </div>
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('description', __('messages.job.description').':') }}<span
                    class="text-danger">*</span>
                {{ Form::textarea('description', $fields['description'], ['class' => 'mumi-textarea form-control' , 'id' => 'details', 'rows' => '10', 'required' => true]) }}
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('tasks', __('messages.job.tasks').':') }}<span class="text-danger">*</span>
                {{ Form::textarea('tasks', $fields['tasks'], ['class' => 'mumi-textarea form-control' , 'id' => 'tasks', 'rows' => '10', 'required' => true]) }}
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                <div class="job-requirements-wrapper">
                    <div class="job-requirements-header d-flex justify-content-between">
                        <div class="job-requirements-label">
                            {{ __('messages.job.requirements').':' }}
                            <span class="text-danger">*</span>
                        </div>
                        <div class="add-job-requirements-wrapper d-flex justify-content-between">
                            <select id="jobRequirementTypeSelect" class="no-validate form-control w-auto mr-2">
                                <?php
                                foreach ($data['jobRequirementType'] as $key => $requirementType) {
                                    echo '<option value="' . $key . '">' . trans($requirementType) . '</option>';
                                }
                                ?>
                            </select>
                            <button id="addJobRequirement"
                                    class="btn btn-primary">{{ __('messages.job.add_job_requirement') }}</button>
                        </div>
                    </div>
                    <div class="job-requirements-list">

                        <div id="jobRequirementPlaceholder"
                             class="job-requirements-placeholder">{{ __('messages.job.requirements_placeholder') }}</div>
                        <div id="jobRequirements"></div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('advantages', __('messages.job.advantages').':') }}
                {{ Form::textarea('advantages', $fields['advantages'], ['class' => 'mumi-textarea form-control' , 'id' => 'advantages', 'rows' => '10']) }}
            </div>
            <div class="form-group col-xl-12 col-md-12 col-sm-12">
                {{ Form::label('perks', __('messages.job.perks').':') }}
                {{ Form::textarea('perks', $fields['perks'], ['class' => 'mumi-textarea form-control' , 'id' => 'perks', 'rows' => '10']) }}
            </div>


            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('salary_from', __('messages.job.salary_from').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::text('salary_from', null, ['class' => 'form-control salary', 'id' => 'fromSalary', 'required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('salary_to', __('messages.job.salary_to').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::text('salary_to', null, ['class' => 'form-control salary', 'id' => 'toSalary', 'required']) }}--}}
            {{--        <span id="salaryToErrorMsg" class="text-danger"></span>--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('currency_id', __('messages.job.currency').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::select('currency_id', $data['currencies'], null,--}}
            {{--                ['id'=>'currencyId','class' => 'form-control','placeholder' => 'Select Currency','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('salary_period_id', __('messages.job.salary_period').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::select('salary_period_id', $data['salaryPeriods'], null, ['id'=>'salaryPeriodsId','class' => 'form-control','placeholder' => 'Select Salary Period','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-4 col-md-4 col-sm-12">--}}
            {{--        {{ Form::label('country', __('messages.company.country').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::select('country_id', $data['countries'], null, ['id'=>'countryId','class' => 'form-control','placeholder' => 'Válasszon országot','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-4 col-md-4 col-sm-12">--}}
            {{--        {{ Form::label('state', __('messages.company.state').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::select('state_id', [], null, ['id'=>'stateId','class' => 'form-control','placeholder' => 'Select State','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-4 col-md-4 col-sm-12">--}}
            {{--        {{ Form::label('city', __('messages.company.city').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::select('city_id', [], null, ['id'=>'cityId','class' => 'form-control','placeholder' => 'Válasszon települést','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('career_level_id', __('messages.job.career_level').':') }}--}}
            {{--        {{ Form::select('career_level_id', $data['careerLevels'],null, ['id'=>'careerLevelsId','class' => 'form-control','placeholder' => 'Select Career Level']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('tagId', __('messages.job_tag.show_job_tag').':') }}--}}
            {{--        {{Form::select('jobTag[]',$data['jobTag'], null, ['class' => 'form-control','id'=>'tagId','multiple'=>true])}}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('degree_level_id', __('messages.job.degree_level').':') }}--}}
            {{--        {{ Form::select('degree_level_id', $data['requiredDegreeLevel'], null, ['id'=>'requiredDegreeLevelId','class' => 'form-control','placeholder' => 'Válasszon végzettségi szintet']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('functional_area_id', __('messages.job.functional_area').':') }}<span--}}
            {{--                class="text-danger">*</span>--}}
            {{--        {{ Form::select('functional_area_id', $data['functionalArea'], null, ['id'=>'functionalAreaId','class' => 'form-control','placeholder' => 'Select Functional Area','required']) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('position', __('messages.job.position').':') }}<span class="text-danger">*</span>--}}
            {{--        {{ Form::number('position',  null, ['id'=>'positionId','class' => 'form-control','placeholder' => 'Select Position','required', 'min' => 0, 'max' => 255]) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-6 col-md-6 col-sm-12">--}}
            {{--        {{ Form::label('experience', __('messages.job_experience.job_experience').':') }}<span--}}
            {{--                class="text-danger">*</span>--}}
            {{--        {{ Form::number('experience',  null, ['id'=>'experienceId','class' => 'form-control','placeholder' => 'Enter experience In Year','required', 'min' => 0, 'max' => 255]) }}--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-3 col-md-3 col-sm-12">--}}
            {{--        <label>{{ __('messages.job.hide_salary').':' }}</label>--}}
            {{--        <label class="custom-switch pl-0 col-12">--}}
            {{--            <input type="checkbox" name="hide_salary" class="custom-switch-input"--}}
            {{--                   id="salary">--}}
            {{--            <span class="custom-switch-indicator"></span>--}}
            {{--        </label>--}}
            {{--    </div>--}}
            {{--    <div class="form-group col-xl-3 col-md-3 col-sm-12">--}}
            {{--        <label>{{ __('messages.job.is_freelance').':' }}</label>--}}
            {{--        <label class="custom-switch pl-0 col-12">--}}
            {{--            <input type="checkbox" name="is_freelance" class="custom-switch-input"--}}
            {{--                   id="freelance">--}}
            {{--            <span class="custom-switch-indicator"></span>--}}
            {{--        </label>--}}
            {{--    </div>--}}


            <input type="hidden" name="job_id" value="{{$job->id}}"/>
            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary mb-1 mr-1','name' => 'save', 'id' => 'saveJob']) }}
                <a href="{{ route('job.index') }}"
                   class="btn btn-secondary text-dark mb-1">{{__('messages.common.cancel')}}</a>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
