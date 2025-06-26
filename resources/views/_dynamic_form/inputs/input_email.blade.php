<div class="form-group col-sm-6">
    {{ Form::label($field['name'], __($field['title']).':') }}
    @if(isset($field['required']))
        <span class="required asterisk-size">*</span>
    @endif
    {{ Form::email(
        'email',
        $field['value'] ?? '',
        [
            'id' => $field['id'],
            'class' => 'form-control',
            'autocomplete' => 'off'
        ])
    }}
</div>

