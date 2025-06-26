@extends('layouts.app')
@section('title')
    {{ __('messages.admin_menu.backoffice_users') }}
@endsection
@push('css')
    @livewireStyles
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.select.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.admin_menu.backoffice_users') }}</h1>
            <div class="section-header-breadcrumb flex-basis-unset">
                <div class="row justify-content-end custom-row-pl-3 align-items-center">
                    <div class="pl-3 py-1 grid-width-100 grid-add-end">
                        <a href="{{ route('backoffice.user.create') }}"
                           class="btn btn-primary form-btn">{{ __('messages.backoffice.user.new_backoffice_user') }}
                            <i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="row">
                @foreach($filters as $field)
                    @include('_dynamic_form.inputs.input_select2_ajax')
                @endforeach
            </div>
            <div class="card">
                <div class="card-body">
                    @include('backoffice.user.table')
                </div>
            </div>
        </div>
        @include('backoffice.user.templates.templates')
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
    <script>
        let isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        let dataTableUrl = "{{ route('backoffice.user.index') }}";
        let actionUrl = "{{ route('backoffice.user.edit',  ['backofficeUserModel' => 'id']) }}";
        let actionDeleteUrl = "{{ route('backoffice.user.destroy',  ['backofficeUserModel' => 'id']) }}";
        let passwordChangeUrl = "{{ route('backoffice.user.passwordChangeRequest', ['backofficeUserModel' => 'id']) }}";
    </script>
    @livewireScripts
    <script src="{{ asset('assets/js/dashboard/admin-dashboard.js?v=2.0.2') }}"></script>
@endpush
