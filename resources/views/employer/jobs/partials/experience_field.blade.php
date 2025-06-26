<div class="form-group" data-type="{{$data['type']}}" data-iterator="{{$data['iterator']}}">
    <div class="row">
        <div class="col-lg-8 col-12">
            <label>{{ __('messages.job_requirements.experience_name') }}</label>
            <input type="text" name="jobRequirements[{{$data['key']}}][{{$data['iterator']}}][{{$data['key']}}_position]" value="{{ $data['defaults']['experience_position'] ?? null }}" class="form-control" />
        </div>
        <div class="col-lg-4 col-12">
            <label>{{ __('messages.job_requirements.experience_years') }}</label>
            <input type="text" name="jobRequirements[{{$data['key']}}][{{$data['iterator']}}][{{$data['key']}}_years]" value="{{ $data['defaults']['experience_years'] ?? null}}" class="form-control" />
        </div>
    </div>
</div>
