<div class="form-inner">
    <input type="hidden" name="type" value="2">
    <div class="form-group">
        <h3>{{__('messages.company.company_details')}}</h3>
        <div class="row">
            <div class="form-group col-12 ">
                <label>{{__('messages.company.vatNumber')}}:
                    <span class="required asterisk-size">*</span>
                </label>
                <input autocomplete="off" type="text" name="vatNumber" id="vatNumber" class="form-control" required>
                <div class="form-tooltip">{{__('messages.company.vat_tooltip')}}</div>
            </div>
            <div class="form-group col-12">
                <label>{{__('messages.company.company_name')}}:
                    <span class="required asterisk-size">*</span></label>
                <input autocomplete="off" type="text" name="companyName" id="companyName" class="form-control" required>
            </div>
            <div class="form-group col-12">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <label>{{__('messages.company.zip_code')}}:
                            <span class="required asterisk-size">*</span></label>
                        <input autocomplete="off" type="text" name="zipCode" id="zipCode" class="form-control" required>
                    </div>
                    <div class="col-md-8 col-12">

                        <label>{{__('messages.company.city')}}:
                            <span class="required asterisk-size">*</span>
                        </label>
                        <input type="text" name="city" id="city" class="form-control" required>
                        <div class="form-tooltip">{{__('messages.company.city_tooltip')}}.</div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 col-md-9 ">
                <label>{{__('messages.company.street')}}:
                    <span class="required asterisk-size">*</span></label>
                <input autocomplete="off" type="text" name="street" id="street" class="form-control" required>
            </div>
            <div class="form-group col-xs-12 col-md-3 ">
                <label>{{__('messages.company.house_number')}}:
                    <span class="required asterisk-size">*</span></label>
                <input autocomplete="off" type="text" name="houseNumber" id="houseNumber" class="form-control" required>
            </div>
            <div class="form-group col-12">
                <div class="row">
                    <div class="col-md-6">
                        <label>{{__('messages.company.floor')}}:</label>
                        <input autocomplete="off" type="text" name="floor" id="floor" class="form-control" />
                    </div>
                    <div class="col-md-6">
                        <label>{{__('messages.company.door')}}:</label>
                        <input autocomplete="off" type="text" name="door" id="door" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 col-md-12 ">
                <label>{{__('messages.company.representative')}}:
                    <span class="required asterisk-size">*</span></label>
                <input autocomplete="off" type="text" name="representative" id="representative" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <h3>{{__('messages.company.contact_title')}}</h3>
        <div class="row">
            <div class="form-group col-12">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <label>{{__('messages.company.surname')}}:
                            <span class="required asterisk-size">*</span>
                        </label>
                        <input autocomplete="off" type="text" name="lastName" id="lastName" class="form-control" required>
                        <div class="form-tooltip">{{__('messages.company.surname_tooltip')}}.</div>
                    </div>
                    <div class="col-md-6 col-12">
                        <label>{{__('messages.company.surname')}}:
                            <span class="required asterisk-size">*</span>
                        </label>
                        <input autocomplete="off" type="text" name="firstName" id="firstName" class="form-control" required>
                        <div class="form-tooltip">{{__('messages.company.firstname_tooltip')}}.</div>
                    </div>
                </div>
            </div>
            <div class="form-group col-12">
                <label><?php echo e(__('messages.company.position')); ?>:
                    <span class="required asterisk-size">*</span>
                </label>
                <?php echo e(Form::select('position_id', $arrPositions, null, ['class' => 'form-control','required','id' => 'employerPosition','placeholder'=> __('messages.company.select_position')])); ?>


                <div class="form-tooltip"><?php echo e(__('messages.company.position_tooltip')); ?>.</div>
            </div>
            <div class="form-group col-12">
                <label>{{__('messages.company.phone')}}:
                    <span class="required asterisk-size">*</span>
                </label>
                <input autocomplete="off" type="text" name="phone" id="phone" class="form-control" required>
                <div class="form-tooltip">{{__('messages.company.phone_tooltip')}}.</div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <h3>{{__('messages.company.account_details')}}</h3>
        <div class="row">
            <div class="form-group col-12">
                <label>{{__('messages.company.email')}}:
                    <span class="required asterisk-size">*</span>
                </label>
                <input  autocomplete="new-password" type="email" name="email" id="employerEmail" class="form-control" required>
                <div class="form-tooltip">{{__('messages.company.email_tooltip')}}.</div>
            </div>
            <div class="form-group col-12">
                <label>{{__('messages.company.password')}}:<span class="required asterisk-size">*</span>
                </label>
                <input  autocomplete="new-password" type="password" name="password" id="employerPassword" class="form-control" required onkeypress="return avoidSpace(event)">
                <div class="form-tooltip">{{__('messages.company.password_tooltip')}}.</div>
            </div>
            <div class="form-group col-12">
                <label>{{__('messages.company.confirm_password')}}:
                    <span class="required asterisk-size">*</span>
                </label>
                <input autocomplete="off" type="password" name="password_confirmation" id="employerConfirmPassword"
                       class="form-control" required onkeypress="return avoidSpace(event)">
                <div class="form-tooltip">{{__('messages.company.confirm_password_tooltip')}}.</div>
            </div>
        </div>
    </div>
    <div class="form-group nomargin mt-3">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary', 'id' => 'btnSave']) }}
        <a href="{{ route('company.index') }}" class="btn btn-secondary text-dark">{{__('messages.common.cancel')}}</a>
    </div>
</div>
