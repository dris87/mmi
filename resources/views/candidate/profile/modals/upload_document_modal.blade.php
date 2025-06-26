<div id="uploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.candidate_profile.upload_doucment') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewDocumentForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    {{ Form::hidden('candidate_id',$candidate->id) }}
                    <div class="form-group col-sm-12">
                        {{ Form::label('title', __('messages.candidate_profile.title').':') }}<span class="text-danger">*</span>
                        <input type="text" class="form-control" name="title" required maxlength="150" id="uploadResumeTitle">
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="file" required>
                            <label class="custom-file-label text-truncate"
                                   for="customFile">{{ __('messages.common.choose_file') }}</label>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnUploadSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.processing')]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1 text-dark"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
