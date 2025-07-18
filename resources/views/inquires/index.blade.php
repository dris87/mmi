@extends('layouts.app')
@section('title')
    {{ __('messages.inquires') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.inquires') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('inquires.table')
                </div>
            </div>
        </div>
    </section>
    @include('inquires.templates.templates')
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let inquiresUrl = "{{ route('inquires.index') }}";
        let deleteInquiry = "{{ url('admin/inquires/') }}";
        let showInquiry = "{{ url('admin/inquires/') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{asset('assets/js/inquires/inquires.js')}}"></script>
@endpush
