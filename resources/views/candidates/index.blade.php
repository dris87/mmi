@extends('layouts.app')
@section('title')
    {{ __('messages.candidates') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header flex-wrap">
            <h1>{{ __('messages.candidates') }}</h1>
            <div class="section-header-breadcrumb flex-content-center">
                <div class="row justify-content-center">
                    <div class="pl-3 mt-1 pr-sm-0 grid-center pad-x-15">

                        <div class="dropdown candidate-index__action d-inline">
                            <a class="btn btn-primary has-icon" type="button"href="{{ route('candidates.create') }}"><i
                                    class="fas fa-plus"></i> {{ __('messages.common.add_candidate') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 col-xl-3 col-sm-12 col-12 d-none filters border border-light"
                         id="candidateFiltersForm">
                        <div class="mb-3">
                            {{  Form::select('job_skill', $jobsSkills, null, ['id' => 'jobSkills', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Job Skill']) }}
                        </div>
                        <div class="mb-3">
                            {{  Form::select('is_immediate_available', $immediateAvailable, null, ['id' => 'immediateAvailable', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Immediate Available']) }}
                        </div>
                        <div class="mb-0">
                            {{  Form::select('is_status', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Status']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none">
            @livewire('admin-candidate-search')
        </div>
        @include('candidates.templates.templates')
        @include('flash::message')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('candidates.table')
                </div>
            </div>
        </div>
    </section>
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
                            @foreach ($arrCandidateStatus as $objCandidateStatus)
                                <option value="{{ $objCandidateStatus->id }}">{{ $objCandidateStatus->name }}</option>
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
    <div id="generatePdfModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('messages.candidates_table.batch_pdf_generate')); ?></h5>
                    <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="generatePdfForm">
                        {{csrf_field()}}
                        <div class="form-group">
                           <p>
                               <span id="items_count"></span> munkaválllaló önéletrajzának generálása és egyben tömörített letöltése.
                           </p>
                        </div>
                        <div class="form-group text-center">
                            <input id="btnGeneratePdfModal" type="submit" name="submitBatchStatusUpdate" class="btn btn-primary" value="{{ __('messages.candidates_table.do_batch_pdf_generate') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="cvModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('messages.candidates_table.cv_list')); ?></h5>
                    <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive">
                        <tr>
                            <th>CV</th>
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
        let candidateUrl = "{{ route('candidates.index') }}";
        let candidateAjaxUrl = "{{ route('candidates.index.ajax') }}";
        let candidateCVDataUrl = "{{ route('candidates.index') }}";
    </script>
    <script src="{{ asset('assets/js/candidate/candidate.js?v=1.0.1') }}"></script>
@endpush
