@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.candidate.dashboard') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/candidate-dashboard.css') }}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.employer_dashboard.jobs') }}</h1>
            <div class="card-header-action w-auto custom-flex-12 mt-0 ml-auto text-right">
                <a href="{{ route('job.create') }}"
                   class="btn btn-info">{{ __('messages.employer_dashboard.add_job') }} <i
                        class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="row mb-1">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-success">
                        <div class="card-icon bg-success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_menu.total_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($totalJobs)?$totalJobs:'0' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-primary">
                        <div class="card-icon bg-primary">
                            <i class="far fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_dashboard.open_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($jobCount)?$jobCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-warning">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-save"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_menu.saved_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($savedJobCount)?$savedJobCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-warning">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_menu.unapproved_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($unapprovedJobCount)?$unapprovedJobCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-warning">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_menu.expiring_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($expiringJobCount)?$expiringJobCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-danger">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-window-close"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_menu.closed_jobs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($closedJobCount)?$closedJobCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section-header flex-wrap">
            <h4>{{ __('messages.employer_dashboard.balance') }}</h4>
            <div class="card-header-action w-auto custom-flex-12 mt-0 ml-auto text-right">
                <a href="##"
                   class="btn btn-info">{{ __('messages.employer_dashboard.balance_topup') }} <i
                        class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="section-body p-0 mt-0">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-success">
                        <div class="card-icon bg-success">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_dashboard.latest_purchased_package') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                M
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-warning">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_dashboard.expiring_package') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                M - 2022.01.13 - 78 CV
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-primary">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_dashboard.available_cvs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($availableCvCount)?$availableCvCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-success">
                        <div class="card-icon bg-success">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.employer_dashboard.released_cvs') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                {{ isset($releasedCvCount)?$releasedCvCount:'0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section-header flex-wrap">
            <h4>{{ __('messages.notification.notifications') }}</h4>
            <div class="card-header-action w-auto custom-flex-12 mt-0 ml-auto text-right">
                <a href="##"
                   class="btn btn-info">{{ __('messages.employer_dashboard.all_notifications') }} <i
                        class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="section-body p-0 mt-0">
            <div class="card">
                <div class="table-responsive table-invoice table-bordered">
                    <table class="table table-striped mb-0">
                        <tbody>
                        <tr class="">
                            <th>{{ __('messages.common.date') }}</th>
                            <th>{{ __('messages.common.title') }}</th>
                            <th>{{ __('messages.common.status') }}</th>
                        </tr>
                        <tr>
                            <td>2022.01.12 12:59</td>
                            <td>"Minta hirdetés" nevű hirdetése lejárt</td>
                            <td>Olvasatlan</td>
                        </tr>
                        <tr>
                            <td>2022.01.12 08:18</td>
                            <td>Új munkavállalói jelentkezés</td>
                            <td>Olvasatlan</td>
                        </tr>
                        <tr>
                            <td>2022.01.11 17:03</td>
                            <td>Új munkavállalói jelentkezés</td>
                            <td>Olvasatlan</td>
                        </tr>
                        <tr>
                            <td>2022.01.11 13:31</td>
                            <td>Új munkavállalói jelentkezés</td>
                            <td>Olvasatlan</td>
                        </tr>
                        <tr>
                            <td>2022.01.11 11:00</td>
                            <td>Új munkavállalói jelentkezés</td>
                            <td>Olvasatlan</td>
                        </tr>
                        <tr>
                            <td>2022.01.10 10:30</td>
                            <td>"Minta hirdetés" nevű hirdetése aktiválásra került</td>
                            <td>Olvasatlan</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section-header flex-wrap">
            <h4>{{ __('messages.employer_dashboard.customer_support') }}</h4>
        </div>
        <div class="section-body p-0 mt-0">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-primary">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.common.phone_number') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                +36 1 123 4567
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-warning">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('messages.common.email') }}</h4>
                            </div>
                            <div class="card-body employer-dashboard-card">
                                ugyfelszolgalat@mumi.hu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
