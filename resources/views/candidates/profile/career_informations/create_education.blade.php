{{ Form::open(['id'=>'addNewEducationForm']) }}
<div class="alert alert-danger d-none" id="validationErrorsBox"></div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('degree_level_id', __('messages.candidate_profile.degree_level').':') }}<span
                class="text-danger">*</span>
        {{ Form::select('degree_level_id', $data['degreeLevels'], null, ['class' => 'form-control','required','id' => 'degreeLevelId','placeholder'=>'Válasszon végzettségi szintet']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('degree_title', __('messages.candidate_profile.degree_title').':') }}<span
                class="text-danger">*</span>
        {{ Form::text('degree_title', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('country', __('messages.company.country').':') }}<span
                class="text-danger">*</span>
        {{ Form::select('country_id', $data['countries'], null, ['id'=>'educationCountryId','required','class' => 'form-control','placeholder' => 'Válasszon országot', 'data-modal-type' => 'education']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('state', __('messages.company.state').':') }}
        {{ Form::select('state_id', [], null, ['id'=>'educationStateId','class' => 'form-control','placeholder' => 'Select State', 'data-modal-type' => 'education']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('city', __('messages.company.city').':') }}
        {{ Form::select('city_id', [], null, ['id'=>'educationCityId','class' => 'form-control','placeholder' => 'Válasszon települést']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('institute',__('messages.candidate_profile.institute').':') }}<span
                class="text-danger">*</span>
        {{ Form::text('institute', null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('result', __('messages.candidate_profile.result').':') }}<span
                class="text-danger">*</span>
        {{ Form::text('result', null, ['class' => 'form-control', 'required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('year', __('messages.candidate_profile.year').':') }}<span
                class="text-danger">*</span>
        {{ Form::selectYear('year', date('Y'), 2000, null, ['class' => 'form-control']) }}
    </div>
</div>
<div class="text-right">
    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary mb-2','id'=>'btnEducationSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
    <button type="button" id="btnEducationCancel"
            class="btn btn-light ml-1 text-dark mb-2">{{ __('messages.common.cancel') }}</button>
</div>
{{ Form::close() }}
