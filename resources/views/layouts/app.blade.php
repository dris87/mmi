<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{config('app.name')}} </title>
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
    <!-- CSS Libraries -->

{{--    <link rel="stylesheet" href="{{ getBrandTypeUrl("favicon") ?? asset('favicon.ico') }}">--}}
@stack('css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/backend/css/components.css')}}">
    <link href="{{ asset('assets/css/infy-loader.css') }}" rel="stylesheet" type="text/css"/>
    {{--    @yield('css')--}}
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=5.0.0') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css?v=5.0.0') }}">
</head>
<body>
<div id="app">
    <div class="infy-loader" id="overlay-screen-lock">
        @include('loader')
    </div>
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('layouts.header')
            @if(Auth::user() && Auth::user()->isBackofficeUser())
                @include('backoffice.user.edit_profile_modal')
            @else
                @include('user_profile.edit_profile_modal')
            @endif
            @include('user_profile.change_password_modal')
        </nav>
        <div class="main-sidebar">
            @include('layouts.sidebar')
        </div>
        <!-- Main Content -->
        <div class="main-content" style="max-width: 1600px; margin: auto;">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>
<script>
    let profileUrl = "{{ url('admin/profile') }}";
    let profileUpdateUrl = "{{ url('admin/profile-update') }}";
    let profilePhoneNo = "{{ old('region_code').old('phone') }}";
    let updateLanguageURL = "{{ url('update-language')}}";
    let changePasswordUrl = "{{ url('admin/change-password') }}";
    let loggedInUserId = "{{ getLoggedInUserId() }}";
    let currentUrlName = "{{ Request::url() }}";
    let readAllNotifications = "{{ url('admin/read-all-notification') }}";
    let readNotification = "{{ url('admin/notification') }}";
    let ajaxCallIsRunning = false;
</script>
<script src="{{ asset('messages.js') }}?v=2.0"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/inttel/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/js/inttel/js/utils.min.js') }}"></script>
<script src="{{ asset('assets/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('web_front/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('web_front/js/validate.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('web/backend/js/stisla.js') }}"></script>
<script src="{{ asset('web/backend/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom.js') }}"></script>
<script>
    (function ($) {
        let currentLocale = "{{ Config::get('app.locale') }}";
        Lang.setLocale(currentLocale);
        $.fn.button = function (action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300);
    });
    $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this),
            target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];

        $(target).modal("hide");
    });
    let utilsScript = "{{asset('assets/js/inttel/js/utils.min.js')}}";
</script>
@stack('scripts')
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('web_front/js/functions.js?v=3.0.0') }}"></script>

<script src="{{ asset('assets/js/user_profile/user_profile.js') }}"></script>
<script src="{{ asset('js/currency.js') }}"></script>
</body>
</html>
