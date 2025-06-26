<?php


namespace App\Models\Factories;

use App\Http\Livewire\CandidateResume;
use App\Models\ActivityLog;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobApplicationFactory extends BaseFactory
{

    /**
     * @param $id
     * @return \App\Models\PostalCode|\Illuminate\Database\Eloquent\Model|mixed|JobApplication
     */
    public function getById($id)
    {
        return JobApplication::where("id",$id)->first();
    }

    /**
     * @return Candidate[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getApplicationsByCompany(Company $objCompany)
    {
        return JobApplication::query()
            ->select(
            "job_applications.id",
            "jobs.job_title",
            "companies.name as company_name",
            "jobs.status as status",
            "jobs.id as job_id",
            "jobs.job_id as job_hash",
            "users.first_name",
            "users.id as user_id",
            "users.last_name",
            "job_stages.name as job_stage_name",
            "cities.name as city",
            "site_city.name as site_name",
            DB::raw("DATE_FORMAT(job_applications.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
        )
            ->join("jobs", "jobs.id", "=", "job_applications.job_id")
            ->join("companies", "companies.id", "=", "jobs.company_id")
            ->join("candidates", "candidates.id", "=", "job_applications.candidate_id")
            ->leftJoin("users", "users.id", "=", "candidates.user_id")
            ->leftJoin("job_stages", "job_stages.id", "=", "job_applications.job_stage_id")
            ->leftJoin("job_locations", "job_locations.job_id", "=", "jobs.id")
            ->leftJoin("cities", "cities.id", "=", "job_locations.city_id")
            ->leftJoin("company_sites", "company_sites.company_id", "=", "companies.id")
            ->leftJoin("cities as site_city", "site_city.id", "=", "company_sites.city_id")
            ->whereRaw('companies.id = ?', [$objCompany->getId()])
            ->groupBy('job_applications.id')
            ->get();
    }


}


