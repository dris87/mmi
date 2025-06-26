<?php
/**
 * @var $objCandidateExtraQualifications \App\Models\CandidateExtraQualifications
 * @var $candidate \App\Models\Candidate
 */

?>

@extends('companies.profile.index')
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
                        <div class="col-xl-6 col-12">
                            <div class="form-group col-12 block_title">
                                {{__('messages.company.company_details')}}
                            </div>
                            <div class="row ">
                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.name')}}</b><br>
                                    {{ $company->name ?? '-' }}
                                </div>
                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.short_name')}}</b><br>
                                    {{ $company->short_name ?? '-' }}
                                </div>
                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.vatNumber')}}</b><br>
                                    {{ $company->vatNumber ?? '-' }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.headquarters')}}</b><br>
                                    {{ $company->address ? $company->address : null }} {{ $company->floor ? $company->floor : null }} {{ $company->door ? $company->door : null }}<br/>
                                    {{ $company->street ? $company->street : null }}<br/>
                                    {{ $city ? $city->name : null }}<br/>
                                    {{ $postcode ? $postcode->postal_code : null }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="form-group col-12 block_title">
                                {{__('messages.company.contact_user_details')}}
                            </div>

                            <div class="row ">
                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.name_representative')}}</b><br>
                                    {{ $user->getFullNameAttribute() }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.representative_position')}}</b><br>
                                    {{ $representativePosition ? $representativePosition->getName() : '-' }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.representative_phone')}}</b><br>
                                    {{ $user->getPhone() }}
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{__('messages.company.representative_email')}}</b><br>
                                    <a href="mailto://{{ $user->getEmail() }}">{{ $user->getEmail() }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-12">
                            <div class="form-group col-12 block_title">
                                {{__('messages.company.register_details')}}
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
                                    @if($user->is_active)
                                        {{__('messages.common.active')}}
                                    @else
                                        {{__('messages.common.inactive')}}
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.candidate.campaign'), []) }}</b><br>
                                    -
                                </div>
                                <div class="form-group col-md-6">
                                    <b>{{ Form::label('email',__('messages.company.account'), []) }}</b><br>
                                    -
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
                    <i class="fas fa-money-bill bg-success"></i>
                    Pénzügy
                </div>
                <div class="section-body p-0 mt-0">
                    <div class="card">
                        <div class="table-responsive table-invoice table-bordered">
                            <table class="table table-striped mb-0">
                                <tbody>
                                <tr class="">
                                    <th>Csomag neve</th>
                                    <th>Egyenleg</th>
                                </tr>
                                <tr>
                                    <td>XL Csomag</td>
                                    <td>9/50</td>
                                </tr>
                                <tr>
                                    <td>S Csomag</td>
                                    <td>0/12</td>
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

        <div class="form-group col-12">
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

@push('page-scripts')
    <script src="{{ asset('assets/js/inttel/js/utils.min.js') }}"></script>
@endpush
