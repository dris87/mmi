<div class="row company-award form-group">
    <div class="form-group col-12">
        <div class="row">
            <div class="col-md-12 col-12">
                <label>{{__('messages.common.title')}}:
                    <span class="required asterisk-size">*</span></label>
                {{ Form::text('companyAwards['.$iterator.'][name]',  $data['title'] ?? null, ['class' => 'form-control', 'required' => true]) }}
            </div>
            <div class="col-md-12 col-12">
                <label>{{__('messages.common.description')}}:
                    <span class="required asterisk-size">*</span></label>
                {{ Form::textarea('companyAwards['.$iterator.'][description]',  $data['description'] ?? null, ['class' => 'mumi-textarea form-control', 'required' => true, 'rows' => '10']) }}
            </div>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <div class="row">
            <div class="px-3">
                {{ Form::label('company_award_image'.$iterator, __('messages.company.award_image').':') }}<span class="text-danger">*</span>
                <label for="company_award_image{{$iterator}}" class="image__file-upload"> {{ __('messages.setting.choose') }}
                </label>
            </div>
            <div class="w-auto pl-3 mt-1">
                <img class="img-thumbnail thumbnail-preview" src="{{(isset($data['image'])) ? $data['image'] : asset('assets/img/placeholder.png')}}">
            </div>
            <div class="col-12">
                {{ Form::file('companyAwards['.$iterator.'][image]',['id'=>'company_award_image'.$iterator,'class' => 'image-uploader']) }}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-xs-12">
            <a href="##" class="mb-0 btn delete-award-item"><i class="fa fa-trash"></i> {{__('messages.common.delete')}}</a>
        </div>
    </div>
    @if($isEdit)
        <input type="hidden" name="companyAwards[{{$iterator}}][mediaId]" value="{{$data['mediaId']}}" />
        <input type="hidden" name="companyAwards[{{$iterator}}][id]" value="{{$data['id']}}" />
    @endif
</div>
