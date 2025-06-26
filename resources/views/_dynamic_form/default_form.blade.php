@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
@endpush
{{ Form::open(['route' => $form['action'], 'id' => $form['id']]) }}
<div class="row">
    @foreach($form['sections'] as $section)
        <div class="form-group col-12 block_title">
            {{ __($section['title']) }}
        </div>
        @foreach($section['fields'] as $field)
            @include("_dynamic_form.inputs.input_" . $field['type'])
        @endforeach
    @endforeach
    <div class="form-group nomargin mt-3">
        {{ Form::submit(__('messages.backoffice.user.save'), ['class' => 'btn btn-primary', 'id' => 'btnSave']) }}
        <a href="{{ route($form['back']) ?? route('admin.dashboard') }}"
           class="btn btn-secondary text-dark">{{__('messages.backoffice.user.cancel')}}</a>
    </div>
</div>
{{ Form::close() }}

@push('scripts')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endpush
