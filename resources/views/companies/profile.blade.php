@extends('layouts.app')
@section('title')
    {{ __('messages.company.edit_employer') }}
@endsection
@stack('page-css')
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="profile">
        <div class="section-header">
            <h1>{{ $company->name }} profilja</h1>
            <a class="font-weight-bold public-profile"
               href="{{ route('companies.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        @include('flash::message')

        <div class="section-body">
            <div>
                @include('layouts.errors')
                <div class="py-0 mt-2">
                    @include('companies.profile.profile_menu')
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
    @livewireScripts
    <script>
        let companyStateUrl = "{{ route('states-list') }}";
        let companyCityUrl = "{{ route('cities-list') }}";
        let employerPanel = false;
        let isEdit = true;
        let phoneNo = "{{ old('region_code').old('phone') }}";
        let countryId = '{{$company->user->country_id}}';
        let stateId = '{{$company->user->state_id}}';
        let cityId = '{{$company->user->city_id}}';
        {{--let utilsScript = "{{asset('assets/js/inttel/js/utils.min.js')}}";--}}
        let industrySaveUrl = "{{ route('industry.store') }}";
        let ownerShipTypeSaveUrl = "{{ route('ownerShipType.store') }}";
        let countrySaveUrl = "{{ route('countries.store') }}";
        let stateSaveUrl = "{{ route('states.store') }}";
        let citySaveUrl = "{{ route('cities.store') }}";
        let companySizeSaveUrl = "{{ route('companySize.store') }}";
    </script>
    @stack('page-scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/companies/create-edit.js')}}"></script>
@endpush
<style>
    .unsetflexwrap{
        flex-wrap: unset !important;
    }
</style>
