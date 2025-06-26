<div class="job-requirement-list">
@if($requirements)
    @foreach($requirements as $requirementType => $requirementData)
        <div class="job-requirement-group {{$requirementType}}-req">
            <div class="job-requirement-group-title">{{ __('messages.job_requirement_types.'.$requirementType) }}</div>
            <ul class="list-style-three">
            @foreach($requirementData as $data)
                    @include('web/jobs/partials/'.$requirementType.'_requirement', array('data'=>$data))
            @endforeach
            </ul>
        </div>
    @endforeach
@endif
</div>
