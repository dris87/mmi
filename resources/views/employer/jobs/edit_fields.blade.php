<div class="row">
    <div class="form-group col-xl-6 col-md-12 col-sm-12">
        {{ Form::label('job_title', __('messages.job.job_title').':') }}<span class="text-danger">*</span>
        {{ Form::text('job_title', $fields['job_title'] ?? null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-xl-6 col-md-12 col-sm-12">
        {{ Form::label('job_position', __('messages.job.job_position').':') }}<span class="text-danger">*</span>
        {{ Form::text('job_position', $fields['job_position'] ?? null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('job_locations', __('messages.job.job_location').':') }}<span class="text-danger">*</span>
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
        {{ Form::label('job_candidate_count', __('messages.job.job_candidate_count').':') }}<span class="text-danger">*</span>
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
        {{ Form::label('description', __('messages.job.description').':') }}<span class="text-danger">*</span>
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
                        foreach($data['jobRequirementType'] as $key => $requirementType){
                            echo '<option value="'.$key.'">'.trans($requirementType).'</option>';
                        }
                        ?>
                    </select>
                    <button id="addJobRequirement" class="btn btn-primary">{{ __('messages.job.add_job_requirement') }}</button>
                </div>
            </div>
            <div class="job-requirements-list">

                <div id="jobRequirementPlaceholder" class="job-requirements-placeholder">{{ __('messages.job.requirements_placeholder') }}</div>
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

    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('job_release_date', __('messages.job.release_date').':') }} <span class="text-danger">*</span>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('job_release_date', $fields['job_release_date'] ?? null, ['class' => 'form-control jobReleaseDateEdit', 'required', 'autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('job_application_due_date', __('messages.job.application_due_date').':') }} <span class="text-danger">*</span>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('job_expiry_date', $fields['job_expiry_date'] ?? null, ['class' => 'form-control jobApplicationDueDateEdit', 'required', 'autocomplete' => 'off']) }}
        </div>
    </div>


    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        <label>{{ __('messages.job.is_anonym').':' }}</label><br>
        <label class="custom-switch pl-0">
            <input type="checkbox" name="is_anonym" <?php echo $fields['is_anonym'] ? 'checked' : ''; ?> class="custom-switch-input isActive"
                   value="1" id="isAnonym">
            <span class="custom-switch-indicator"></span>
        </label>
    </div>
    <input type="hidden" name="job_id" value="{{$job->id}}" />
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
    <?php
       if($fields['status'] == $draftStatusId){ ?>
        <button type="submit" value="saveDraft" class="btn btn-primary mr-1 mb-1 saveDraft"
                name="saveDraft">{{__('messages.common.save_as_draft')}}
        </button>
        <?php } ?>
        {{ Form::submit(__('messages.common.sendToReview'), ['class' => 'btn btn-primary mb-1 mr-1','name' => 'save', 'id' => 'saveJob']) }}
        <a href="{{ route('job.index') }}" class="btn btn-secondary text-dark mb-1">{{__('messages.common.cancel')}}</a>
    </div>

</div>
