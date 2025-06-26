<div class="row">
    <div class="form-group col-12 block_title">
        {{__('messages.backoffice.user.form_section_default_data')}}
    </div>
    <div class="form-group col-md-6 col-12">
        {{ Form::label('first_name', __('messages.backoffice.user.first_name').':') }}
        <span class="required asterisk-size">*</span>
        {{ Form::text('first_name', $data['values']['first_name'] ?? null, ['class' => 'form-control','id' => 'first_name','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-md-6 col-12">
        {{ Form::label('last_name', __('messages.backoffice.user.last_name').':') }}
        <span class="required asterisk-size">*</span>
        {{ Form::text('last_name', $data['values']['last_name'] ?? null, ['class' => 'form-control','id' => 'last_name','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('dob', __('messages.backoffice.user.birth_date').':') }}
        {{ Form::text('dob', $data['values']['dob'] ?? null, ['class' => 'form-control','id' => 'birthDate','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-md-6 col-12">
        {{ Form::label('notified_name', __('messages.backoffice.user.notified_name').':') }}
        <span class="required asterisk-size">*</span>
        {{ Form::text('notified_name', $data['values']['notified_name'] ?? null, ['class' => 'form-control','id' => 'notified_name','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-md-6 col-12">
        {{ Form::label('notified_phone', __('messages.backoffice.user.notified_phone').':') }}
        <span class="required asterisk-size">*</span>
        {{ Form::number('notified_phone', $data['values']['notified_phone'] ?? null, ['class' => 'form-control'])}}
    </div>
    <div class="form-group col-12 block_title">
        {{__('messages.backoffice.user.form_section_professional')}}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('position', __('messages.backoffice.user.position').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{ Form::select('position_id', $data['positions'], $data['values']['position_id'] ?? null, ['class' => 'form-control','required','id' => 'position_id','placeholder'=> __('messages.candidate.select_marital_status')]) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('branch_office_id', __('messages.backoffice.user.branch_office').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{ Form::select('branch_office_id', $data['branch_offices'], $data['values']['branch_office_id'] ?? null, ['class' => 'form-control','required','id' => 'branch_office_id','placeholder'=> __('messages.candidate.select_marital_status')]) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('superior', __('messages.backoffice.user.superior').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{ Form::select('superior_id', $data['superiors'], $data['values']['superior_id'] ?? null, ['class' => 'form-control','required','id' => 'superior_id','placeholder'=> __('messages.candidate.select_marital_status')]) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('email',__('messages.backoffice.user.email').':') }}<span class="text-danger">*</span>
        {{ Form::email('email', $data['values']['email'] ?? null, ['class' => 'form-control','id' => 'email','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('phone', __('messages.backoffice.user.phone').':') }}<br>
        {{ Form::number('phone', $data['values']['phone'] ?? null, ['class' => 'form-control'])}}
        <div class="form-tooltip">Javasolt mobiltelefonszámot megadni.</div>
        {{ Form::hidden('region_code',null,['id'=>'prefix_code']) }}
        <br>
        <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
        <span id="error-msg" class="hide"></span>
    </div>
    <div class="form-group col-12 block_title">
        {{__('messages.backoffice.user.form_section_permission')}}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('position', __('messages.backoffice.user.main_permission').':') }}
        <span class="text-danger">*</span>
        <div class="input-group">
            {{ Form::select('main_permission_id', $data['permissions'], $data['values']['main_permission_id'] ?? null, ['class' => 'form-control','required','id' => 'main_permission_id','placeholder'=> __('messages.candidate.select_marital_status')]) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('extra_permissions', __('messages.backoffice.user.extra_permissions').':') }}
        <div class="input-group">
            {{ Form::select('extra_permission_ids[]', $data['permissions'], $data['values']['extra_permission_ids'] ?? [], ['multiple' => true, 'class' => 'form-control','required','id' => 'extra_permission_ids','placeholder'=> __('messages.candidate.extra_permissions')]) }}
        </div>
    </div>


    <div class="form-group nomargin mt-3">
        {{ Form::submit(__('messages.backoffice.user.save'), ['class' => 'btn btn-primary', 'id' => 'btnSave']) }}
        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-secondary text-dark">{{__('messages.backoffice.user.cancel')}}</a>
    </div>
</div>
