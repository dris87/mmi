<div class="company-gallery form-group col-xl-3 col-lg-3 col-md-6 col-6">
    <div class="form-group">
        <div class="row">
            <div class="w-auto pl-3 mt-1">
                <img class="img-thumbnail thumbnail-preview" src="{{(isset($data['image'])) ? $data['image'] : asset('assets/img/placeholder.png')}}">
            </div>
            <div class="px-3 col-12">
                {{ Form::label('company_gallery_image'.$iterator, __('messages.company.gallery_item').':') }}
                <label for="company_gallery_image{{$iterator}}" class="image__file-upload"> {{ __('messages.setting.choose') }}
                </label>
            </div>
            <div class="col-12">
                {{ Form::file('companyGallery['.$iterator.'][image]',['id'=>'company_gallery_image'.$iterator,'class' => 'image-uploader']) }}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-xs-12">
            <a href="##" class="mb-0 btn delete-gallery-item"><i class="fa fa-trash"></i> {{__('messages.common.delete')}}</a>
        </div>
    </div>
    @if($isEdit)
        <input type="hidden" name="companyGallery[{{$iterator}}][id]" value="{{$data['mediaId']}}" />
    @endif
</div>
