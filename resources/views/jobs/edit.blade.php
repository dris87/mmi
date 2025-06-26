@extends('layouts.app')
@section('title')
    {{ __('messages.job.edit_job') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job.edit_job') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{!! URL::previous() !!}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <?php
                /** @var  $job \App\Models\Job */
            ?>
            <div class="company-profile-header">
                <div class="cover-photo" style="background-image: url('{{($job->company->getCoverPhoto()) ? $job->company->getCoverPhoto() : asset('assets/img/placeholder.png')}}');">
                </div>
                <div class="company-logo" style="background-image: url('{{($job->company->getLogo()) ? $job->company->getLogo() : asset('assets/img/placeholder.png')}}');">
                </div>
            </div>
            @include('jobs.edit_fields')

        </div>
    </section>
    @include('jobs.modals.applicants_modal')
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateJobRequest') !!}
    <script>
        let jobStateUrl = "{{ route('states-list') }}";
        let jobCityUrl = "{{ route('cities-list') }}";
        let employerPanel = true;
        let jobId = {{$job->id}};
        let getRequirementData = true;
        let jobApprovedURL = "{{ route('admin.job.approve') }}";
        let jobStatusURL = "{{ route('admin.job.status') }}";
        let jobSendMailUrl = "{{ route('admin.job.send.email') }}";
        let jobActivateUrl = "{{ route('admin.job.activate') }}";
    </script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jobs/create-edit.js?v=1.1.2')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>
@endpush
