<div class="form-group" data-type="{{$data['type']}}" data-iterator="{{$data['iterator']}}">
    <label>{{ __('messages.job_requirements.personal_skill_name') }}</label>
    <input type="text" name="jobRequirements[{{$data['key']}}][{{$data['iterator']}}][{{$data['key']}}_name]" value="{{  $data['defaults']['personal_skill_name'] ?? null }}" class="form-control" />
</div>
