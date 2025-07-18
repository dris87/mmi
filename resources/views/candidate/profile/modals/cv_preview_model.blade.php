<div class="modal fade" id="cvModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content resumes-width">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.your_cv') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4 cv-download-content" id="cvTemplate">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary generate_resume">{{ __('messages.candidate_profile.generate_resume')}}</button>
                <button type="button" class="btn btn-light ml-1 text-dark "
                        data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
