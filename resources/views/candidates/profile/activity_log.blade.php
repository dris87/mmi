<?php
/**
 * @var $objCandidateExtraQualifications \App\Models\CandidateExtraQualifications
 * @var $candidate \App\Models\Candidate
 */

?>

@extends('candidates.profile.index')
@push('page-css')
    <link href="{{ asset('assets/css/dashboard-widgets.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('section')

    <div class="row">

        <div class="form-group col-12">
            <div class="card">
                <div class="card-body">
                    @include('candidates.event-log-table')
                </div>
            </div>
        </div>

    </div>

@endsection
<script>
    let emailTemplateUrl = "/admin/event-log/candidate/<?=$candidate->id?>";

</script>
@push('page-scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/event_log/candidate_event_log.js') }}"></script>
@endpush
