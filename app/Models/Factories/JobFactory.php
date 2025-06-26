<?php


namespace App\Models\Factories;

use App\Models\Company;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Job::class;
    }

    /**
     * @param Job $objJob
     * @param $status_id
     * @return Job|false
     */
    public function setStatusTo(Job $objJob, $status_id)
    {
        $objJob->setStatus($status_id);
        if (!$objJob->save()) {
            return false;
        }

        return $objJob;
    }

    public function setSuspended(Job $objJob, $suspending_staus)
    {
        $objJob->setSuspended($suspending_staus);
        if (!$objJob->save()) {
            return false;
        }

        return $objJob;
    }

    /**
     * @param $job_id
     * @return mixed
     */
    public function getByJobId($job_id)
    {
        return $this->model::where('job_id', '=', $job_id)->get();
    }

    /**
     * @param $job_id
     * @return mixed
     */
    public function getByCompany(Company $objCompany)
    {
        return $this->model::where('company_id', '=', $objCompany->getId())->get();
    }

    /**
     * @param array $categories
     * @return mixed
     */
    public function getJobsByCategoryArray(array $categories)
    {
        return $this->model::query()->join('job_assigned_categories')
            ->whereIn('job_assigned_categories.job_categoriy_id', '=', $categories)->whereDate(
                'job.job_expiry_date',
                '>=',
                Carbon::now()->toDateString()
            )->get();
    }

}
