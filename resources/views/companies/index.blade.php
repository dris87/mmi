@extends('layouts.app')
@section('title')
    {{ __('messages.employers') }}
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
            <h1>{{ __('messages.company.employers_heading') }}</h1>
            <div class="section-header-breadcrumb flex-basis-unset">
                <div class="row justify-content-end custom-row-pl-3 align-items-center">
{{--                    @if(count($data) > 0)--}}
{{--                        <div class="pl-3 pr-md-3 pr-0 py-1 grid-width-100">--}}
{{--                            <div class="card-header-action">--}}
{{--                                {{  Form::select('is_featured', $featured, null, ['id' => 'filter_featured', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Featured Company']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="pl-3 pr-md-3 pr-0 py-1 grid-width-100">--}}
{{--                            <div class="card-header-action w-100">--}}
{{--                                {{  Form::select('is_stauts', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter w-100', 'placeholder' => 'Select Status']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <div class="pl-3 py-1 grid-width-100 grid-add-end">
                        <a href="{{ route('company.create') }}"
{{--                           {{ route('company.create') }}--}}
                           class="btn btn-primary form-btn">{{ __('messages.company.new_employer') }}
                            <i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('companies.templates.templates')
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('companies.table')
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
@push('scripts')
    @livewireScripts
    <script>
        let companiesUrl = "{{ route('company.index') }}";
        let getCompaniesUrl = "{{ route('get.companies.data') }}";
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{asset('assets/js/companies/companies.js?v=2.1')}}"></script>
@endpush

