<?php


namespace App\Models\Factories;

use App\Models\Job;
use App\Models\JobExperience;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobExperienceFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = JobExperience::class;
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

            $obj = new JobExperience();
            $obj->setJobId($objJob->getId());
            $obj->setPosition($item['position']);
            $obj->setYears($item['years']);

            if(!$obj->save()){
                return false;
            }

        }
        return true;
    }

}
