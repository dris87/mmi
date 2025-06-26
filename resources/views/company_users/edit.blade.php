@extends('layouts.app')
@section('title')
    {{ __('messages.coworker.edit_coworker') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.coworker.edit_coworker') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{!! URL::previous() !!}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <?php
            /** @var  $job \App\Models\CompanyUser */
            ?>
            @include('company_users.edit_fields')
        </div>
    </section>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanyUserRequest') !!}
    <script>
        let coworkerId = {{$objCompanyUser->getId()}};
    </script>
    <script src="{{ asset('assets/js/coworkers/create-edit.js?v=1.1.2')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endpush
