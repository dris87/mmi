<div class="form-group" data-type="{{$data['type']}}" data-iterator="{{$data['iterator']}}">
    <div class="row">
        <div class="col-lg-8 col-12">
            <label>{{ __('messages.job_requirements.language_skill_name') }}</label>
            {{ Form::select('jobRequirements['.$data['key'].']['.$data['iterator'].']['.$data['key'].'_id]', $data['languageSkills'],  $data['defaults']['language_skill_id'] ?? null, ['class' => 'form-control']) }}
        </div>
        <div class="col-lg-4 col-12">
            <label>{{ __('messages.job_requirements.language_skill_level') }}</label>
            {{ Form::select('jobRequirements['.$data['key'].']['.$data['iterator'].']['.$data['key'].'_level]', $data['skillLevels'], $data['defaults']['language_skill_level'] ?? null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
