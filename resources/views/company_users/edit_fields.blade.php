<input type="hidden" id="id" value="<?= $objCompanyUser->id ?>">

{{ Form::model($objCompanyUser, ['route' => ['admin.coworker.update', $objCompanyUser->id], 'method' => 'post', 'id' => 'editCompanyUserForm']) }}
<input type="hidden" name="redirect_url_after_update" value="{!! URL::previous() !!}">
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                <label>{{ __('messages.coworker.last_login').':' }}</label><br>
                <div class="input-group">
                    <div class="input-group-prepend mumi-input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="coworker-date">{{ $objCompanyUser->getLastLogin() ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                <label>{{ __('messages.coworker.registered_at').':' }}</label><br>
                <div class="input-group">
                    <div class="input-group-prepend mumi-input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="coworker-date">{{ $objCompanyUser->getCreatedAt() }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('last_name', __('messages.coworker.last_name').':') }}<span class="text-danger">*</span>
                {{ Form::text('last_name', $objUser ? $objUser->getLastName() : null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('first_name', __('messages.coworker.first_name').':') }}<span class="text-danger">*</span>
                {{ Form::text('first_name', $objUser ? $objUser->getFirstName() : null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('email', __('messages.coworker.email').':') }}<span class="text-danger">*</span>
                {{ Form::email('email', $objUser ? $objUser->getEmail() : null, ['class' => 'form-control','required', 'autocomplete' => false]) }}
            </div>
            <div class="form-group col-xl-6 col-md-12 col-sm-12">
                {{ Form::label('phone', __('messages.coworker.phone').':') }}<span class="text-danger">*</span>
                {{ Form::text('phone', $objCompanyUser ? $objCompanyUser->getPhone() : null, ['class' => 'form-control','required']) }}
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('company_site_id', __('messages.coworker.site').':') }}
                <div class="mumi-select2-wrapper" id="companySiteSelectWrapper" data-site-id="{{$objCompanyUser ? $objCompanyUser->getCompanySiteId() : null}}">
                    {{ Form::select('company_site_id', array('' => trans('messages.coworker.select_site')) + $arrCompanySites, $objCompanyUser ? $objCompanyUser->getCompanySiteId() : null, ['id'=>'companySiteId','class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('position_id', __('messages.coworker.position').':') }}<span
                    class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('position_id', $arrPositions, $objCompanyUser ? $objCompanyUser->getCoworkerPositionId() : null, ['id'=>'coworkerPositionId','class' => 'form-control', 'required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('permission_id', __('messages.coworker.role').':') }}<span
                    class="text-danger">*</span>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('permission_id', $arrPermissions, $objCompanyUser ? $objCompanyUser->getPermissionId() : null, ['id'=>'coworkerPermissionId','class' => 'form-control', 'required']) }}
                </div>
            </div>
            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                {{ Form::label('is_active', __('messages.coworker.status').':') }}<br>
                <div class="mumi-select2-wrapper">
                    {{ Form::select('is_active', [0 => trans('messages.common.inactive'), 1 => trans('messages.common.active')], $objCompanyUser ? $objCompanyUser->getIsActive() : null, ['id' => 'coworkerStatus', 'class' => 'form-control']) }}
                </div>
            </div>
            <input type="hidden" name="coworker_id" value="{{$objCompanyUser->id}}"/>
            <input type="hidden" name="redirect_url_after_update" value="{!! URL::previous() !!}">
            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-xs-12 text-lg-left text-center">
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary mb-1 mr-1','name' => 'save', 'id' => 'saveCompanyUser']) }}
                        <a id="backBtn" href="{!! URL::previous() !!}" class="btn btn-secondary text-dark mb-1">{{__('messages.common.cancel')}}</a>
                    </div>
                    <div class="col-lg-6 col-xs-12 text-lg-right text-center">
                        {{ Form::button(__('messages.coworker.delete_coworker'), ['class' => 'btn btn-danger mb-1 ml-auto','name' => 'delete', 'id' => 'deleteCoworker']) }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
