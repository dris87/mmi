<div id="editEducationModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.candidate_profile.edit_education') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'editEducationForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                <input type="hidden" id="educationId">
                <div class="row">
                    {{ Form::hidden('candidate_id', $candidate->id) }}
                    <div class="form-group col-sm-6">
                        {{ Form::label('degree_level_id', __('messages.candidate_profile.degree_level').':') }}<span
                                class="text-danger">*</span>
                        {{ Form::select('degree_level_id', $data['degreeLevels'], null, ['class' => 'form-control','required','id' => 'degreeLevelId','placeholder'=>'Válasszon végzettségi szintet','id' => 'editDegreeLevel']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('degree_title', __('messages.candidate_profile.degree_title').':') }}<span
                                class="text-danger">*</span>
                        {{ Form::text('degree_title', null, ['class' => 'form-control','id' => 'editDegreeTitle']) }}
                    </div>
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {{ Form::label('country', __('messages.company.country').':') }}<span--}}
{{--                                class="text-danger">*</span>--}}
{{--                        {{ Form::select('country_id', $data['countries'], null, ['id'=>'editEducationCountry','class' => 'form-control','placeholder' => 'Válasszon országot', 'data-modal-type' => 'education', 'data-is-edit' => 'true']) }}--}}
{{--                    </div>--}}
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {{ Form::label('state', __('messages.company.state').':') }}--}}
{{--                        {{ Form::select('state_id', [], null, ['id'=>'editEducationState','class' => 'form-control','placeholder' => 'Select State', 'data-modal-type' => 'education', 'data-is-edit' => 'true']) }}--}}
{{--                    </div>--}}
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {{ Form::label('city', __('messages.company.city').':') }}--}}
{{--                        {{ Form::select('city_id', [], null, ['id'=>'editEducationCity','class' => 'form-control','placeholder' => 'Válasszon települést', 'data-is-edit' => 'true']) }}--}}
{{--                    </div>--}}
                    <div class="form-group col-md-4 col-12">
                        {{ Form::label('zipCode',__('messages.candidate.postal_code').':') }}<span class="text-danger">*</span>
                        {{ Form::text('zipCode', null, ['class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-md-8 col-12">
                        {{ Form::label('city',__('messages.candidate.city').':') }}<span class="text-danger">*</span>
                        {{ Form::text('city', null, ['class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('institute',__('messages.candidate_profile.institute').':') }}<span
                                class="text-danger">*</span>
                        {{ Form::text('institute', null, ['class' => 'form-control','required', 'id' => 'editInstitute']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('result', __('messages.candidate_profile.result').':') }}<span
                                class="text-danger">*</span>
                        {{ Form::text('result', null, ['class' => 'form-control', 'required', 'id' => 'editResult']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('year', __('messages.candidate_profile.year').':') }}<span
                                class="text-danger">*</span>1
                        {{ Form::selectYear('year', date('Y'), 1980, null, ['class' => 'form-control', 'id' => 'editYear']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('year_to', __('messages.candidate_profile.year_to').':') }}<span
                            class="text-danger">*</span>
                        {{ Form::selectYear('year_to', date('Y'), 1980, null, ['class' => 'form-control','placeholder'=>'Jelenleg is tart','id' => 'editYearTo']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnEditEducationSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" id="btnEditEducationCancel" class="btn btn-light ml-1 text-dark"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
