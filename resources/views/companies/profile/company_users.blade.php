<?php
/**
 * @var $company \App\Models\Company
 */

?>

@extends('companies.profile.index')
@push('page-css')
    <link href="{{ asset('assets/css/dashboard-widgets.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('section')

    <div class="row">

        <div class="form-group col-12">
            <div class="card">
                <div class="card-body">
                    @include('flash::message')
                    @include('companies.templates.templates')
                    @include('companies.coworker-table')
                </div>
            </div>
        </div>
    </div>
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
                                <option value="1">{{ __('messages.common.active') }}</option>
                                <option value="0">{{ __('messages.common.inactive') }}</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <input id="btnBatchStatusUpdate" type="submit" name="submitBatchStatusUpdate" class="btn btn-primary" value="{{ __('messages.common.edit') }}" />
                        </div>

                    </form>
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>{{ __('messages.common.id') }}</th>
                            <th>{{ __('messages.common.name') }}</th>
                            <th>{{ __('messages.common.current_status') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    let getCoworkersUrl = "/admin/coworkers/company/<?=$company->id?>";

</script>
@push('page-scripts')
    <script src="{{ asset('assets/js/companies/coworkers.js') }}"></script>
@endpush
