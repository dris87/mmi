@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.candidate.dashboard') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/candidate-dashboard.css') }}">
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')

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
                            <i class="fas fa-address-card"></i></a>
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
@push('scripts')
    <script>
        let generateCandidatePdfUrl = "/generate-candidate-cv/<?=$candidate->id?>";
        let cvTemplateUrl = "/get-cv-template/<?=$candidate->id?>";
        let languages = <?=$jsonLanguages?>;
        let setResumeStatusUrl = "/media/status"
        let resumeDownloadUrl = "/candidate/media";
        let resumeUploadUrl = "{{ route('candidate.my_resumes') }}";
        let cvListUrl = "/get-candidate-cv-list/<?=$candidate->id?>";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{asset('assets/js/candidate/create-edit.js')}}"></script>
    <script src="{{ asset('assets/js/candidate-profile/candidate-resume.js?v=1')}}"></script>
    <script src="{{ asset('assets/js/candidate/cv.js') }}"></script>
    <script src="{{asset('assets/js/candidate-profile/cv-builder.js')}}"></script>
@endpush

