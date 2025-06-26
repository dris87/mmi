@extends('layouts.app')

@section('title')
    {{ __('messages.backoffice.user.' . (isset($user) ? 'backoffice_user_edit' : 'new_backoffice_user')) }}
@endsection

@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <section class="section">
        @if(isset($user))
            <div class="section-header">
                <h1>{{ ($user->getName() ?? '') .' '. __('messages.backoffice.user.edit_backoffice_user') }}</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('admin.dashboard') }}"
                       data-id="{{ $user->getId() }}"
                       class="btn password-reset-btn mr-4 btn-primary form-btn float-right">{{ __('messages.backoffice.user.password_change_request_title') }}</a>
                    <a href="{{ route('backoffice.user.index') }}"
                       class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
                </div>
            </div>
        @else
        <div class="section-header">
            <h1>{{ __('messages.backoffice.user.new_backoffice_user') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('backoffice.user.index') }}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>

        @endif
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    @include('_dynamic_form.default_form')
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script> let passwordChangeUrl = "{{ route('backoffice.user.passwordChangeRequest', ['backofficeUserModel' => 'id']) }}";</script>

    {!! JsValidator::formRequest('App\Http\Requests\Backoffice\CreateBackofficeUserRequest', '#' . $form['id']) !!}

    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/create-edit.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.password-reset-btn', function (e) {
                e.preventDefault();
                const element = $(this);
                swal({
                    title: Lang.get('messages.common.reset_the_password'),
                    text: Lang.get('messages.common.are_you_sure_want_to_reset_the_password'),
                    type: 'warning',
                    showCancelButton: true,
                    closeOnConfirm: true,
                    showLoaderOnConfirm: false,
                    confirmButtonColor: '#6777ef',
                    cancelButtonColor: '#d33',
                    cancelButtonText: Lang.get('messages.common.no'),
                    confirmButtonText: Lang.get('messages.common.yes')
                }, function () {
                    const url = passwordChangeUrl.replace('id', element.attr('data-id'));

                    $.post(
                        url,
                        {
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        '',
                        'json'
                    ).done(function (objResponse) {
                        console.log(objResponse);
                        if (!objResponse.success) {
                            iziToast.error({
                                title: Lang.get('messages.common.error'),
                                message: objResponse.message,
                                position: 'topRight'
                            });
                        } else {
                            iziToast.success({
                                title: Lang.get('messages.common.success'),
                                message: objResponse.message,
                                position: 'topRight'
                            });
                        }

                        //location.reload();

                    }).fail(function () {
                        iziToast.error({
                            title: Lang.get('messages.common.error'),
                            message: Lang.get('messages.common.process_failed'),
                            position: 'topRight'
                        });
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            resetJsValidation("backofficeUserForm");

        });
    </script>
@endpush
