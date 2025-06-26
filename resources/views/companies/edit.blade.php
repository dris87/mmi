@extends('layouts.app')
@section('title')
    {{ __('messages.company.edit_employer') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
{{--    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">--}}
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.company.edit_employer') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('company.index') }}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::model($company, ['route' => ['company.update', $company->id], 'method' => 'put', 'files' => 'true', 'id' => 'editCompanyForm']) }}

                    @include('companies.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
            @include('industries.add_modal')
            @include('ownership_types.add_modal')
            @include('countries.add_modal')
            @include('states.add_modal')
            @include('cities.add_modal')
            @include('company_sizes.add_modal')
        </div>
    </section>
@endsection

@push('scripts')

@endpush
