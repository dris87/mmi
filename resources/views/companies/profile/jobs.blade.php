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
    <section class="section">

        <div class="section-body">
            @include('jobs.templates.templates')
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('jobs.table')
                </div>
            </div>
        </div>
    </section>

@endsection
@include('jobs.modals.applicants_modal')
<script>
    let companyId = <?=$company->id?>;
</script>

@push('scripts')
    @livewireScripts
    <script>
        let frontJobDetail = "{{ route('front.job.details') }}";
        let JobsListUrl = "{{ route('admin.getJobsData.index',$company->id) }}";
        let JobsEdit = "{{ route('admin.job.edit',"slug") }}";
        let appliedApplicantsUrl = "{{ route('admin.applied.applicants',"slug") }}"
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/jobs/admin-job-table.js?v=1.0.7')}}"></script>
    <script>
        var array_job_status = <?php echo json_encode(\App\Models\Job::STATUS) ?>;
    </script>
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
