<div class="card company-video">
    <div class="card-header" id="heading{{$iterator}}">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-11 col-9 px-0">
                    <button class="video-item-title btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$iterator}}" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $data['title'] ?? 'Videó #'.$videoNum; ?>
                    </button>
                </div>
                <div class="col-md-1 col-3 text-right">
                    <a href="##" class="btn btn-primary delete-video-item"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div id="collapse{{$iterator}}" class="collapse show" aria-labelledby="heading{{$iterator}}" data-parent="#companyVideos">
        <div class="card-body">
            <div class="company-video-wrapper">
                <div class="form-group">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-10 col-12">
                            <div class="">
                                <label>{{ __('messages.company.video_url') }}</label>
                                <input name="videos[{{ $iterator }}][url]" class="video-input form-control"  value="{{$data['video_url'] ?? null}}"/>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 text-center">
                            <button class="addVideoBtn btn btn-primary">{{ __('messages.common.fetch') }}</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('messages.company.video_title') }}</label>
                                    <input name="videos[{{ $iterator }}][title]" class="video-title-input form-control" value="{{$data['title'] ?? null}}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('messages.company.video_description') }}</label>
                                    <textarea rows="6" name="videos[{{ $iterator }}][description]" class="video-description-input form-control">{{ $data['description'] ?? null}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group">
                                    {{ Form::label('video_thumbnail_'.$iterator, __('messages.company.video_thumbnail').':') }}<span class="text-danger">*</span><br/>
                                    <label for="video_thumbnail_{{$iterator}}" class="image__file-upload"> {{ __('messages.setting.choose') }}</label>
                                </div>
                                <div class="w-auto pl-5 mt-1">
                                    <img class="img-thumbnail thumbnail-preview" src="{{(isset($data['thumbnail'])) ? asset($data['thumbnail']) : asset('assets/img/placeholder.png')}}">
                                </div>
                                <div class="col-12">
                                    {{ Form::file('videos['.$iterator.'][thumbnail]',['id'=>'video_thumbnail_'.$iterator,'class' => 'video-thumbnail-uploader']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="video-container">
                            <iframe class="responsive-iframe" src="{{ $data['embed_url'] ?? null }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
