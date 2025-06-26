<div class="form-group" data-type="{{$data['type']}}" data-iterator="{{$data['iterator']}}" >
    <label>{{ __('messages.job_requirements.drivers_license') }}</label>
    {{ Form::select('jobRequirements['.$data['key'].']['.$data['iterator'].']['.$data['key'].'_id]', $data['driversLicense'], $data['defaults']['drivers_license_id'] ?? null, ['class' => 'form-control']) }}
</div>
