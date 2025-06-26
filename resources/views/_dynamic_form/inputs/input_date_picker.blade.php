<div class="form-group col-md-6 col-12">
    {{ Form::label($field['name'], __($field['title']).':') }}
    @if(isset($field['required']))
        <span class="required asterisk-size">*</span>
    @endif
    {{ Form::text(
        $field['name'],
        $field['value'] ?? '',
        [
            'id' => $field['id'],
            'class' => 'form-control',
            'autocomplete' => 'off'
        ])
    }}
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#{{$field['id']}}').datetimepicker(DatetimepickerDefaults({
                format: 'YYYY-MM-DD',
                useCurrent: true,
                sideBySide: true,
                maxDate: new Date()
            }));
        });
</script>
@endpush
