<?php


namespace App\Models\Factories;

use App\Models\CandidateLanguage;
use App\Models\Job;
use App\Models\JobAssignedType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobAssignedTypeFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = JobAssignedType::class;
    }


    /**
     * @param Job $objJob
     * @return mixed
     */
    public function getByJob(Job $objJob)
    {
        return $this->model::where('job_id', '=', $objJob->id)->get();
    }

    /**
     * @param Job $objJob
     * @return void
     */
    public function clearByJob(Job $objJob){

        $arrItems = $this->getByJob($objJob);
        if($arrItems){
            foreach ($arrItems as $key => $obj){
                $obj->delete();
            }
        }
    }

    /**
     * @param Job $objJob
     * @param array $arrData
     * @return bool
     */
    public function createOrUpdate(Job $objJob, array $arrData): bool
    {
        $this->clearByJob($objJob);

        foreach ($arrData as $key => $item){

            $obj = new JobAssignedType();
            $obj->setJobId($objJob->getId());
            $obj->setJobTypeId($item['job_type_id']);

            if(!$obj->save()){
                return false;
            }

        }
        return true;
    }

}
