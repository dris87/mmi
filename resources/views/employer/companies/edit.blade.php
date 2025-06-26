@extends('employer.layouts.app')
@section('title')
    {{ __('messages.company.edit_employer') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header justify-content-between featured-badge-margin">
            <h1>{{ __('messages.company.edit_employer') }}</h1>

            @if($isFeaturedEnable)
                @if($company->activeFeatured)
                    <div class="badge badge-info d-inline-block rounded">
                        {{ __('messages.front_settings.featured') }}
                        {{ __('messages.front_settings.exipre_on') }}
                        {{ (new Carbon\Carbon($company->activeFeatured->end_time))->format('d/m/y') }}</div>
                @else
                    @if($isFeaturedAvilabal)
                        <button class="btn btn-info ml-auto"
                                id="makeFeatured">{{ __('messages.front_settings.make_featured') }}</button>
                    @else
                        <button class="btn btn-info ml-auto disabled" data-toggle="tooltip" data-placement="bottom"
                                title="{{ __('messages.front_settings.featured_employer_not_available') }}"
                                data-toggle="tooltip">{{ __('messages.front_settings.make_featured') }}</button>
                    @endif
                @endif
            @endif
        </div>
        <div class="section-body">
            @include('flash::message')
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::model($company, ['route' => ['frontend.company.update', $company->id], 'method' => 'post', 'files' => 'true', 'id' => 'editCompanyForm']) }}

                    @include('employer.companies.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>let companyId = <?=$company->id?>;</script>

    {!! JsValidator::formRequest('App\Http\Requests\UpdateEmployerRequest') !!}

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/companies/profile.js') }}"></script>
@endpush

