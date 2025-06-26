<?php
namespace App\Helpers;

use App\Models\Job;

class JobHelper
{
    public static function standardiseJobData(Job $job)
    {
        $fields = $job->toArray();

        $fields['job_shifts'] = $job->jobShifts()->count() > 0 ? $job->jobShifts()->pluck('job_shift_id') : null;
        $fields['job_types'] = $job->jobTypes()->count() > 0 ? $job->jobTypes()->pluck('job_type_id') : null;
        $fields['job_locations'] = $job->jobLocations()->count() > 0 ? $job->jobLocations()->pluck('city_id') : null;
        $fields['job_categories'] = $job->jobCategories()->count() > 0 ? $job->jobCategories()->pluck('job_category_id') : null;
        $fields['job_position'] = $job->getPosition();
        $fields['job_candidate_count'] = $job->getCandidateCount();
        $fields['jobRequirements'] = $job->getJobRequirements();

        return $fields;
    }
}
