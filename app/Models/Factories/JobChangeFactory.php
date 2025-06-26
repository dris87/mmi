<?php


namespace App\Models\Factories;

use App\Models\CandidateLanguage;
use App\Models\Job;
use App\Models\JobAssignedType;
use App\Models\JobChange;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobChangeFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = JobChange::class;
    }


    /**
     * @param Job $objJob
     * @return mixed|JobChange
     */
    public function getPendingChangeByJob(Job $objJob)
    {
        return $this->model::where('job_id', '=', $objJob->id)->where('is_approved', '=', '0')->get()->first();
    }

    public function getAllByJob(Job $objJob)
    {
        return $this->model::where('job_id', '=', $objJob->id)->get()->all();
    }


    public function create(Job $objJob, array $arrFormData): bool
    {

        $objJobChange = new JobChange();
        $objJobChange->setJobId($objJob->getId());
        $objJobChange->setFormData(json_encode($arrFormData));

        if(!$objJobChange->save()){
            return false;
        }

        return true;
    }

    public function update(JobChange $objJobChange, array $arrFormData): bool
    {

        $objJobChange->setFormData(json_encode($arrFormData));

        if(!$objJobChange->save()){
            return false;
        }

        return true;
    }

}
