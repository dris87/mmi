<div id="changePasswordModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content border-radius">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user.change_password') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'changePasswordForm']) }}
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="alert alert-danger display-none" id="editPasswordValidationErrorsBox"></div>
                    {{ Form::hidden('user_id',null,['id'=>'pfUserId']) }}
                {{ Form::hidden('is_active',1) }}
                {{csrf_field()}}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('current password', __('messages.company.current_password').':') }}<span
                                class="required">*</span>
                        <div class="input-group">
                            <input class="form-control input-group__addon" id="pfCurrentPassword" type="password"
                                   name="password_current" required autofocus>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('password', __('messages.company.new_password').':') }}<span class="required">*</span>
                        <div class="input-group">
                            <input class="form-control input-group__addon" id="pfNewPassword" type="password"
                                   name="password" required>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('password_confirmation', __('messages.company.confirm_password').':') }}<span
                                class="required">*</span>
                        <div class="input-group">
                            <input class="form-control input-group__addon" id="pfNewConfirmPassword" type="password"
                                   name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnPrPasswordEditSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" class="btn btn-light border-radius"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
