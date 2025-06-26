@extends('candidates.profile.index')
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
                                    <th style="width:50%;" scope="col">{{ __('messages.application.application_name') }}</th>
                                    <th scope="col">{{ __('messages.application.company_name') }}</th>
                                    <th scope="col">{{ __('messages.application.job_status') }}</th>
                                    <th scope="col">{{ __('messages.application.mode') }}</th>
                                    <th scope="col">{{ __('messages.application.status') }}</th>
                                    <th scope="col">{{ __('messages.application.date_created') }}</th>
                                    <th style="width: 70px" scope="col">{{ __('messages.application.options') }}</th>
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
    @include('candidates.templates.templates')
@endsection
@push('page-scripts')
    <script>
        let candidateApplicationsUrl = "/admin/application/candidate/<?=$candidate->id?>";
    </script>

    <script src="{{ asset('assets/js/candidate-profile/candidate-applications-table.js') }}"></script>
@endpush
<script>

    var array_job_status = <?php echo json_encode(\App\Models\Job::STATUS) ?>;

</script>



