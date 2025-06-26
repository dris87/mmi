<div class="row company-site form-group">
    <div class="form-group col-12">
        <div class="row">
            <div class="col-md-4 col-12">
                <label>{{__('messages.company.zip_code')}}:
                    <span class="required asterisk-size">*</span></label>
                {{ Form::text('companySites['.$iterator.'][zip_code]',  $data['postcode'] ?? null, ['class' => 'form-control company-postcode-input']) }}

            </div>
            <div class="col-md-8 col-12">

                <label>{{__('messages.company.city')}}:
                    <span class="required asterisk-size">*</span>
                </label>
                {{ Form::text('companySites['.$iterator.'][city]', $data['city'] ?? null, ['class' => 'form-control company-city-input']) }}
                <div class="form-tooltip">{{__('messages.company.city_tooltip')}}.</div>
            </div>
        </div>
    </div>
    <div class="form-group col-xs-12 col-md-9 ">
        <label>{{__('messages.company.street')}}:
            <span class="required asterisk-size">*</span></label>
        {{ Form::text('companySites['.$iterator.'][street]', $data['street'] ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-xs-12 col-md-3 ">
        <label>{{__('messages.company.house_number')}}:
            <span class="required asterisk-size">*</span></label>
        {{ Form::text('companySites['.$iterator.'][address]', $data['address'] ?? null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-12">
        <div class="row">
            <div class="col-md-6">
                <label>{{__('messages.company.floor')}}:</label>
                {{ Form::text('companySites['.$iterator.'][floor]', $data['floor'] ?? null, ['class' => 'form-control']) }}
            </div>
            <div class="col-md-6">
                <label>{{__('messages.company.door')}}:</label>
                {{ Form::text('companySites['.$iterator.'][door]', $data['door'] ?? null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="col-12">
            <div class="col-xs-12">
                <a href="##" class="mb-0 btn delete-site-item"><i class="fa fa-trash"></i> {{__('messages.common.delete')}}</a>
            </div>
    </div>
</div>
