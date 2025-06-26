<div id="editProfileModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content left-margin">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user.edit_profile') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'editProfileForm', 'route' => 'backoffice.user.updateProfile', 'files'=>true]) }}
            <div class="modal-body">
                {{ Form::hidden('user_id',null,['id' => 'editUserId']) }}
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-sm-12 block_title">
                        {{__('messages.backoffice.user.form_section_default_data')}}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('first_name', __('messages.backoffice.user.first_name').':') }}<span
                            class="text-danger">*</span>
                        {{ Form::text('first_name', null, ['id'=>'firstName','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('last_name', __('messages.backoffice.user.last_name').':') }}
                        {{ Form::text('last_name', null, ['id'=>'lastName','class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('dob', __('messages.backoffice.user.birth_date').':') }}<span class="required asterisk-size">*</span>
                        {{ Form::text('dob',  '', [ 'id' => 'dateOfBirth', 'class' => 'form-control', 'autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('email', __('messages.backoffice.user.email').':') }}<span class="text-danger">*</span>
                        {{ Form::email('email', null, ['id'=>'userEmail','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('phone', __('messages.backoffice.user.phone').':') }}
                        {{ Form::tel('phone', null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'profilePhone']) }}
                        {{ Form::hidden('region_code',null,['id'=>'profilePrefixCode']) }}
                        <br>
                        <span id="profileValidMsg" class="hide profile-valid-msg">✓ &nbsp; Valid</span>
                        <span id="profileErrorMsg" class="hide profile-error-msg"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('notified_name', __('messages.backoffice.user.notified_name').':') }}<span
                            class="text-danger">*</span>
                        {{ Form::text('notified_name', null, ['id'=>'notifiedName','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('notified_phone', __('messages.backoffice.user.notified_phone').':') }}
                        {{ Form::tel('notified_phone', null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'notifiedPhone']) }}
                        <br>
                        <span id="profileValidMsg" class="hide profile-valid-msg">✓ &nbsp; Valid</span>
                        <span id="profileErrorMsg" class="hide profile-error-msg"></span>
                    </div>

                    <div class="form-group col-12 block_title">
                        {{__('messages.backoffice.user.form_section_professional')}}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('position', __('messages.backoffice.user.position').':') }}
                        {{ Form::select('position_id', [], null, ['class' => 'form-control', 'disabled' => true, 'id' => 'positionId','placeholder'=> __('messages.backoffice_user.select_position')]) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('branch_office_id', __('messages.backoffice.user.branch_office').':') }}
                        {{ Form::select('branch_office_id', [], null, ['class' => 'form-control', 'disabled' => true, 'id' => 'branchOfficeId','placeholder'=> __('messages.backoffice_user.select_branch_office')]) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('superior_id', __('messages.backoffice.user.superior').':') }}
                        {{ Form::select('superior_id', [], null, ['class' => 'form-control', 'disabled' => true, 'id' => 'superiorId','placeholder'=> __('messages.backoffice_user.select_superior')]) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnPrEditSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" class="btn btn-light left-margin"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="changeLanguageModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content left-margin">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user_language.change_language')}}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'changeLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div>
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('language',__('messages.user_language.language').':') }}<span
                            class="required">*</span>
                        {{ Form::select('language', getUserLanguages(), getLoggedInUser()->language, ['id'=>'language','class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnLanguageChange','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" class="btn btn-light left-margin" data-dismiss="modal"
                            onclick="document.getElementById('language').value = '{{getLoggedInUser()->language}}'">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="changeLanguageModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content left-margin">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user_language.change_language')}}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'changeLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div>
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('language',__('messages.user_language.language').':') }}<span
                            class="required">*</span>
                        {{ Form::select('language', getUserLanguages(), getLoggedInUser()->language, ['id'=>'language','class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnLanguageChange','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" class="btn btn-light left-margin" data-dismiss="modal"
                            onclick="document.getElementById('language').value = '{{getLoggedInUser()->language}}'">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Backoffice\CreateBackofficeUserRequest', '#editProfileForm') !!}
    <script>
        profileUpdateUrl = "{{ route('backoffice.user.updateProfile') }}";
        let backofficeProfileUrl = "{{ route('backoffice.user.editProfile') }}";

        let select2BackofficePositionsUrl = "{{ route('select2.backofficePositions') }}";
        let select2BackofficeBranchOfficesUrl = "{{ route('select2.backofficeBranchOffices') }}";
        let select2BackofficeSuperiorsUrl = "{{ route('select2.backofficeSuperiors') }}";
    </script>
    <script src="{{ asset('assets/js/backoffice/user/backofficeuser_profile.js?v=2.0.0') }}"></script>

    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dateOfBirth').datetimepicker(DatetimepickerDefaults({
                format: 'YYYY-MM-DD',
                useCurrent: true,
                sideBySide: true,
                maxDate: new Date()
            }));
        });
    </script>
@endpush
