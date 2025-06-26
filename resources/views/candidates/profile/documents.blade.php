@extends('candidates.profile.index')
@section('section')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="section-header-breadcrumb mb-3">
                        <a href="#"
                           class="btn btn-primary uploadDocumentsModal">{{ __('messages.candidate_profile.upload_doucment') }}
                            <i class="fas fa-upload"></i></a>
                    </div>
                </div>

                @include('candidates.templates.templates')

                <div class="card">
                    <div class="card-body">
                        @include('candidates.profile.documents_table')
                    </div>
                </div>

            </div>
        </div>
        @include('candidate.profile.modals.upload_document_modal')
    </div>

@endsection
@push('page-scripts')
    <script>
        let cvTemplateUrl = "/get-cv-template/<?=$candidate->id?>";
        let setResumeStatusUrl = "/media/status"
        let resumeDownloadUrl = "/admin/media";
        let documentUploadUrl = "{{ route('candidate.documents') }}";
        let documentsListUrl = "/get-candidate-documents-list/<?=$candidate->id?>";
    </script>
    <script src="{{ asset('assets/js/candidate-profile/candidate-documents.js?v=1')}}"></script>
    <script src="{{ asset('assets/js/candidate/documents.js') }}"></script>
    <script src="{{asset('assets/js/candidate-profile/cv-builder.js')}}"></script>
@endpush

