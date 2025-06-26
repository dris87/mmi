@extends('employer.layouts.app')
@section('title')
{{ __('messages.employer_menu.activity_log') }}
@endsection
@push('css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header flex-wrap">
            <h1 class="mr-3">{{ __('messages.employer_menu.activity_log') }}</h1>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped table-bordered" id="eventCandidateLogTbl">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('messages.event_log.id') }}</th>
                                <th style="min-width: 40%;" scope="col">{{ __('messages.event_log.description') }}</th>
                                <th scope="col">{{ __('messages.event_log.causer_id') }}</th>
                                <th scope="col">{{ __('messages.event_log.date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    let emailTemplateUrl = "{{ route("employer.activity-log-data") }}"; ;
    console.log("--");
</script>
@push('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/event_log/candidate_event_log.js') }}"></script>
@endpush


