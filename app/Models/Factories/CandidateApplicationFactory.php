<?php


namespace App\Models\Factories;

use App\Http\Livewire\CandidateResume;
use App\Models\ActivityLog;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CandidateApplicationFactory extends BaseFactory
{

    /**
     * @return Candidate[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getApplicationsByCandidate(Candidate $objCandidate)
    {
        return JobApplication::query()->select(
            "job_applications.id",
            "jobs.job_title",
            "companies.name as company_name",
            "jobs.status as status",
            "job_stages.name as job_stage_name",
            DB::raw("DATE_FORMAT(jobs.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
        )
            ->leftJoin("jobs", "jobs.id", "=", "job_applications.job_id")
            ->leftJoin("companies", "companies.id", "=", "jobs.company_id")
            ->leftJoin("candidates", "candidates.id", "=", "job_applications.candidate_id")
            ->leftJoin("users", "users.id", "=", "candidates.user_id")
            ->leftJoin("job_stages", "job_stages.id", "=", "job_applications.job_stage_id")
            ->whereRaw('candidates.id = ?', [$objCandidate->getId()])
            ->get();
    }

    /**
     * @param Job $objJob
     * @return Candidate[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCandidateByApplication(Job $objJob){

        return JobApplication::query()
            ->whereRaw('job_applications.job_id = ?', [$objJob->getId()])
            ->get();
    }

}


