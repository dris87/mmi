<?php
/**
 * @var $company \App\Models\Company
 */

?>

@extends('companies.profile.index')
@section('section')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        <form id="candidateCVTableForm" method="POST">
                            <table class="table table-responsive-sm table-striped table-bordered"
                                   id="applicationCandidateLogTbl">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('messages.application.id') }}</th>
                                    <th scope="col"> Hirdetés címe</th>
                                    <th scope="col"> Település</th>
                                    <th scope="col">Munkavállaló neve (ID)</th>
                                    <th scope="col">Kiközvetítve</th>
                                    <th scope="col">Jelentkezés módja</th>
                                    <th scope="col">Státusz</th>
                                    <th scope="col">Telephely</th>
                                    <th scope="col">{{ __('messages.application.options') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('companies.profile.templates.templates')
@endsection
@push('page-scripts')
    <script>
        let frontJobDetail = "{{ route('front.job.details') }}";
        let resumeDownloadUrl = "/admin/media";
        let companyApplicationsUrl = "{{ route("admin.company.applications",$company->id) }}";
        let appliedApplicantResumesUrl = "{{ route('admin.applied.applicant.resumes',"slug") }}"

    </script>

    <script src="{{ asset('assets/js/companies/company_application_table.js') }}"></script>
@endpush
<script>

    var array_job_status = <?php echo json_encode(\App\Models\Job::STATUS) ?>;

</script>
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


