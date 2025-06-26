@php
    $multiple = $field['multiple'] ?? false;
    $selectData = [
        'id' => $field['id'],
        'class' => 'form-control',
        'placeholder'=> __($field['placeholder'] ?? '')
    ];
    if (isset($field['required'])) {
        $selectData[] = 'required';
    }
    if ($multiple) {
        $selectData['multiple'] = $field['multiple'];
    }
@endphp

<div class="form-group {{ $field['class_size'] ?? 'col-sm-6' }}">
    {{ Form::label($field['name'], __($field['title']).':') }}
    @if(isset($field['required']))
        <span class="text-danger">*</span>
    @endif
    <div class="input-group">
        {{ Form::select(
            $field['name'],
            [],
            $field['value'],
            $selectData)
        }}
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            let params = '';
            <?php if(isset($field['excluded'])){
                echo "params = '?excluded=".$field['excluded']."';";
            } ?>
            $('#{{ $field['id'] }}').select2({
                width: '100%',
                language: {
                    searching: function() {
                        return "";
                    },
                    errorLoading: function() {
                        return Lang.get('messages.select2.errorLoading');
                    }
                },
                @if(isset($field['multiple']) && $field['multiple'])
                multiple: true,
                @endif
                ajax: {
                    url: '{{ route($field['ajaxUrl']) }}' + params,
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {
                                    id: obj.id,
                                    text: obj.text
                                }
                            })
                        };
                    }
                }
            });
        });

        @if(!$multiple && isset($field['value']) && isset($field['value']['text']))
        @if(!empty($field['value']['text']))
        var newOption = new Option(
            '{{ $field['value']['text'] }}',
            {{ $field['value']['id'] }},
            true, true
        );
        $('#{{ $field['id'] }}').append(newOption).trigger('change');
        @endif

        @elseif($multiple && isset($field['value']))
            @foreach($field['value'] as $value)
                @if(!empty($value['text']))
                var newOption = new Option(
                    '{{ $value['text'] }}',
                    {{ $value['id'] ?? null }},
                    true,
                    true
                );
                $('#{{ $field['id'] }}').append(newOption).trigger('change');
                @endif
            @endforeach
        @endif
    </script>
@endpush
