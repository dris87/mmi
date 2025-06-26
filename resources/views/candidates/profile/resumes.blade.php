@extends('candidates.profile.index')
@section('section')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="section-header-breadcrumb mb-3">
                        <a href="#"
                           class="btn btn-primary  uploadResumeModal">{{ __('messages.candidate_profile.upload_resume') }}
                            <i class="fas fa-upload"></i></a>
                        <a href="#"
                           class="btn btn-warning  generate_resume">{{ __('messages.candidate_profile.generate_resume') }}
                            <i class="fas fa-address-card"></i></a>
                        <a href="#cvModal" role="button" class="btn btn-info cv-preview "
                           data-toggle="modal">{{ __('messages.cv.preview') }}
                            <i class="fas fa-address-card"></i></a></a>
                    </div>
                </div>

                @include('candidates.templates.templates')

                <div class="card">
                    <div class="card-body">
                        @include('candidates.profile.cv_table')
                    </div>
                </div>

            </div>
        </div>
        @include('candidate.profile.modals.upload_resume_modal')
        @include('candidates.profile.modals.cv_preview_model')
    </div>

@endsection
@push('page-scripts')
    <script>
        let cvTemplateUrl = "/get-cv-template/<?=$candidate->id?>";
        let languages = <?=$jsonLanguages?>;
        let setResumeStatusUrl = "/media/status"
        let resumeDownloadUrl = "/admin/media";
        let resumeUploadUrl = "{{ route('candidate.resumes') }}";
        let cvListUrl = "/get-candidate-cv-list/<?=$candidate->id?>";
    </script>
    <script src="{{ asset('assets/js/candidate-profile/candidate-resume.js')}}"></script>
    <script src="{{ asset('assets/js/candidate/cv.js') }}"></script>
    <script src="{{asset('assets/js/candidate-profile/cv-builder.js')}}"></script>
@endpush

