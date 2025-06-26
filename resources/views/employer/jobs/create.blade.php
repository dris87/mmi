@extends('employer.layouts.app')
@section('title')
    {{ __('messages.job.new_job') }}
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
            <h1>{{ __('messages.job.new_job') }}</h1>
            <div class="section-header-breadcrumb">
                <a id="previewButton" href="##"
                   class="btn btn-primary previewButton form-btn float-right">{{ __('messages.common.preview') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'job.store','id' => 'createJobForm', 'class' => 'employer-job-form']) }}

                    @include('employer.jobs.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CreateJobRequest') !!}
    <script>

        let jobStateUrl = "{{ route('states-list') }}";
        let jobCityUrl = "{{ route('cities-list') }}";
        let employerPanel = true;
        let jobId = null;
    </script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jobs/create-edit.js?v=1.0.0')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>
@endpush
