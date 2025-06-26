@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.profile') }}
@endsection
@stack('page-css')
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section profile">

        @include('flash::message')

        <div class="section-body">
            <div>
                @include('layouts.errors')
                <div class="py-0 mt-2">
                    @include('candidate.profile.profile_menu')
                </div>
            </div>

            @include('marital_status.add_modal')
            @include('skills.add_modal')
            @include('languages.add_modal')
            @include('career_levels.add_modal')
            @include('job_categories.add_modal')
        </div>


    </section>
@endsection
@push('scripts')
    <script>
        let generateCandidatePdfUrl = "/generate-candidate-cv/<?=$candidate->id?>";
        let maritalStatusSaveUrl = "{{ route('maritalStatus.store') }}";
        let skillSaveUrl = "{{ route('skills.store') }}";
        let languageSaveUrl = "{{ route('languages.store') }}";
        let countrySaveUrl = "{{ route('countries.store') }}";
        let stateSaveUrl = "{{ route('states.store') }}";
        let citySaveUrl = "{{ route('cities.store') }}";
        let careerLevelSaveUrl = "{{ route('careerLevel.store') }}";
        let industrySaveUrl = "{{ route('industry.store') }}";
        let functionalAreaSaveUrl = "{{ route('functionalArea.store') }}";

        let companyStateUrl = "{{ route('states-list') }}";
        let jobCategorySaveUrl = "{{ route('job-categories.store') }}";
        let companyCityUrl = "{{ route('cities-list') }}";
        let defaultImageUrl = "{{ asset('assets/img/main-logo.png') }}";
    </script>
    @stack('page-scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{asset('assets/js/candidate/create-edit.js')}}"></script>
@endpush
<style>
    .unsetflexwrap{
        flex-wrap: unset !important;
    }
</style>
