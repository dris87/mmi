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
                    <div class="row ">
                        <div class="col-6">
                            <div class="form-group col-12 block_title">
                                Személyes Adatok
                            </div>
                            <div class="row ">
                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('last_name',__('messages.user.full_address'), []) }}</b><br>
                                    <?php
                                    echo $objPostCode?$objPostCode->postal_code:"";
                                    echo $objCity?" ".$objCity->name:"";
                                    echo $candidate?" ".$candidate->address:"";
                                    ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <b> {{ Form::label('dob', __('messages.candidate.birth_date').':', []) }}</b><br>
                                    {{ $user->dob }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('phone_number',__('messages.candidate.phone'), []) }}</b><br>
                                    {{ $user->phone }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.candidate.email'), []) }}</b><br>
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group col-12 block_title">
                                Regisztrációs adatok
                            </div>

                            <div class="row ">


                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.candidate.registration_date'), []) }}</b><br>
                                    {{ $user->created_at }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.candidate.last_activity_date'), []) }}</b><br>
                                    {{ isset($objLastActivity)?$objLastActivity->created_at:"-" }}
                                </div>

                                <div class="form-group col-md-6">

                                    <b>{{ Form::label('email',__('messages.candidate.status'), []) }}</b><br>
                                    <?=(isset($candidate->candidate_status_id) && isset($arrCandidateStatuses))?$arrCandidateStatuses[$candidate->candidate_status_id]["name"]:""; ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.candidate.campaign'), []) }}</b><br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <section class="section">
                <div class="section-header small-section-icon-wrapper flex-wrap section_header">
                    <i class="fas fa-exclamation-circle bg-danger "></i>
                    Figyelmeztetések
                </div>
                <div class="section-body p-0 mt-0">
                    <div class="card">
                        <div class="table-responsive table-invoice table-bordered">
                            <table class="table table-striped mb-0">
                                <tbody>
                                <tr class="">
                                    <th>Dátum</th>
                                    <th>Megnevezés</th>
                                </tr>
                                <tr>
                                    <td>2022.01.12 12:59</td>
                                    <td>Figyelmeztets 1</td>
                                </tr>
                                <tr>
                                    <td>2022.01.12 12:59</td>
                                    <td>Figyelmeztets 1</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <div class="col-md-6">
            <section class="section">
                <div class="section-header small-section-icon-wrapper flex-wrap section_header">
                    <i class="fas fa-tasks bg-warning"></i>
                    Teendők
                </div>
                <div class="section-body p-0 mt-0">
                    <div class="card">

                            <div class="table-responsive table-invoice table-bordered">
                                <table class="table table-striped mb-0">
                                    <tbody>
                                    <tr>
                                        <td>2022.01.12 12:59</td>
                                        <td>"Minta hirdetés" nevű hirdetése lejárt</td>
                                        <td>Olvasatlan</td>
                                    </tr>
                                    <tr>
                                        <td>2022.01.12 12:59</td>
                                        <td>"Minta hirdetés" nevű hirdetése lejárt</td>
                                        <td>Olvasatlan</td>
                                    </tr>
                                    <tr>
                                        <td>2022.01.12 12:59</td>
                                        <td>"Minta hirdetés" nevű hirdetése lejárt</td>
                                        <td>Olvasatlan</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-6">
            <section class="section">
                <div class="section-header small-section-icon-wrapper flex-wrap section_header">
                    <i class="fas fa-comment bg-primary"></i>
                    Megjegyzések
                </div>
                <div class="section-body p-0 mt-0">
                    <div class="card">
                        <div class="table-responsive table-invoice table-bordered">
                            <table class="table table-striped mb-0">
                                <tbody>
                                <tr class="">
                                    <th>Dátum</th>
                                    <th>Megjegyzés</th>
                                </tr>
                                <tr>
                                    <td>2022.01.12 12:59</td>
                                    <td>Megjegyzés 1</td>
                                </tr>
                                <tr>
                                    <td>2022.01.12 12:59</td>
                                    <td>Megjegyzés 1</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="form-group col-6">
            <div class="card">
                <div class="card-body">

                    <div class="row ">

                        <div class="form-group col-12 block_title">
                            Megjegyzes
                        </div>
                        <div class="form-group col-md-6">
                            <div class="row ">
                                <div class="form-group col-md-12">
                                    {{ Form::label('comment',__('messages.candidate.comment').':') }}
                                    <span class="text-danger">*</span>
                                    {{ Form::text('comment', null, ['class' => 'form-control','required']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('comment_type', __('messages.candidate.comment_type').':') }}
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        {{ Form::select('comment_type', [], null, ['class' => 'form-control','required','id' => 'comment_type','placeholder'=> __('messages.candidate.comment_type')]) }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('deadline', __('messages.candidate.deadline').':', []) }}
                                    <span class="text-danger">*</span>
                                    {{ Form::text('deadline', null, ['class' => 'form-control','id' => 'comment_deadline','autocomplete' => 'off']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('commant_details',__('messages.candidate.comment_details').':') }}
                            {{ Form::textarea('commant_details', null, ['class' => 'form-control', 'style'=>'height:140px','rows' => 4]) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>


@endsection
<script>
    let countryId = '{{$user->country_id}}';
    let stateId = '{{$user->state_id}}';
    let cityId = '{{$user->city_id}}';
    let isEdit = true;

</script>
@push('page-scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCandidateRequest') !!}
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('assets/js/custom/input_price_format.js')}}"></script>
    <script src="{{asset('assets/js/candidate-profile/candidate-general.js')}}"></script>

    <script src="{{ asset('assets/js/inttel/js/utils.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/phone-number-country-code.js') }}"></script>
@endpush
