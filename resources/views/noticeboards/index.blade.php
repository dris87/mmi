@extends('layouts.app')
@section('title')
    {{ __('messages.noticeboards') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header flex-wrap">
            <h1 class="mb-2">{{ __('messages.noticeboards') }}</h1>
            <div class="section-header-breadcrumb">
                @if($noticeboards->count() > 0)
                    <div class="card-header-action grid-flex-end">
                        {{  Form::select('is_active', $statusArr, null, ['id' => 'noticeboard_filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => __('messages.image_slider.select_status')]) }}
                    </div>
                @endif
                <a href="#" class="btn btn-primary form-btn addNoticeboardModal ml-2 back-btn-right">{{ __('messages.job_skill.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('noticeboards.table')
                </div>
            </div>
        </div>
        @include('noticeboards.templates.templates')
        @include('noticeboards.add_modal')
        @include('noticeboards.edit_modal')
        @include('noticeboards.show_modal')
    </section>
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let noticeboardUrl = "{{ route('noticeboards.index') }}/";
        let noticeboardSaveUrl = "{{ route('noticeboards.store') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <script src="{{asset('assets/js/noticeboards/noticeboards.js')}}"></script>
@endpush
