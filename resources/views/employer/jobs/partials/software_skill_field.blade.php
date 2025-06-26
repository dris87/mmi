<div class="form-group" data-type="{{$data['type']}}" data-iterator="{{$data['iterator']}}">
    <div class="row">
        <div class="col-lg-8 col-12">
            <label>{{ __('messages.job_requirements.software_skill_name') }}</label>
            <input type="text" name="jobRequirements[{{$data['key']}}][{{$data['iterator']}}][{{$data['key']}}_name]" value="{{ $data['defaults']['software_skill_name'] ?? null}}" class="form-control" />
        </div>
        <div class="col-lg-4 col-12">
            <label>{{ __('messages.job_requirements.software_skill_level') }}</label>
            {{ Form::select('jobRequirements['.$data['key'].']['.$data['iterator'].']['.$data['key'].'_level]', $data['skillLevels'],  $data['defaults']['software_skill_level'] ?? null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
