<div class="form-group col-md-6 col-12">
    {{ Form::label($field['name'], __($field['title']).':') }}
    @if(isset($field['required']))
        <span class="required asterisk-size">*</span>
    @endif
    {{ Form::number(
        $field['name'],
        $field['value'] ?? '',
        [
            'id' => $field['id'],
            'class' => 'form-control',
            'autocomplete' => 'off'
        ])
    }}
</div>

