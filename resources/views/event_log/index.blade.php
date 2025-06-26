@extends('layouts.app')
@section('title')
    {{ __('messages.admin_menu.event_log') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{ __('messages.admin_menu.event_log') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form id="eventLogTableForm" method="POST">
                        <table class="table table-responsive-sm table-striped table-bordered" id="eventLogTbl">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"></th>
                                <th scope="col">{{ __('messages.event_log.id') }}</th>
                                <th scope="col">{{ __('messages.event_log.description') }}</th>
                                <th scope="col">{{ __('messages.event_log.subject_type') }}</th>
                                <th scope="col">{{ __('messages.event_log.subject_id') }}</th>
                                <th scope="col">{{ __('messages.event_log.causer_id') }}</th>
                                <th scope="col">{{ __('messages.event_log.created_at') }}</th>
                                <th scope="col">{{ __('messages.event_log.updated_at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
        @include('event_log.templates.templates')
    </section>
@endsection
@push('scripts')
    <script>
        let emailTemplateUrl = "{{ route('admin.event-log') }}";
    </script>
    <script src="{{ asset('assets/js/event_log/event_log.js?v=3.0.1') }}"></script>
@endpush
<style>
    .btn-options {
        padding: 0px 4px !important;
        width: 26px;
        display: inline-block;
        height: 26px;
        padding-top: 6px !important;
        line-height: 30px;
    }
</style>
