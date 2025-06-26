<?php
/**
 * @var $company \App\Models\Company
 */

?>

@extends('companies.profile.index')
@push('page-css')
    <link href="{{ asset('assets/css/dashboard-widgets.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('section')

    <div class="row">

        <div class="form-group col-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($company, ['route' => ['company.update', $company->id], 'method' => 'post', 'files' => 'true', 'id' => 'editCompanyForm']) }}

                    @include('companies.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
@endsection
<script>
    let companyId = <?=$company->id?>;
</script>
@push('page-scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanyRequest') !!}
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/companies/profile.js') }}"></script>
@endpush
