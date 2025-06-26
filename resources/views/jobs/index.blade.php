@extends('layouts.app')
@section('title')
    {{ __('messages.jobs') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.job.heading') }}</h1>
        </div>
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


    @include('jobs.modals.applicants_modal')

    <div id="statusUpdateModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('messages.candidates_table.batch_status_update')); ?></h5>
                    <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="statusUpdateForm">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="batchStatus">{{ __('messages.candidates_table.status') }}</label>
                            <select id="batchStatus" class="form-control" name="batchStatus">
                                @foreach (\App\Models\Job::STATUS as $key => $status)
                                    <option value="{{ $key }}">{{ trans('messages.job_status.'.$status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <input id="btnBatchStatusUpdate" type="submit" name="submitBatchStatusUpdate" class="btn btn-primary" value="{{ __('messages.common.edit') }}" />
                        </div>

                    </form>
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th>Azonosító</th>
                            <th>Név</th>
                            <th>Aktuális státusz</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
    <script>
        let frontJobDetail = "{{ route('front.job.details') }}";
        let JobsListUrl = "{{ route('admin.getJobsData.index') }}";
        let JobsEdit = "{{ route('admin.job.edit',"slug") }}";
        let appliedApplicantsUrl = "{{ route('admin.applied.applicants',"slug") }}"
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/jobs/admin-job-table.js?v=1.0.8')}}"></script>
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
