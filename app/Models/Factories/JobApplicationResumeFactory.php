<?php


namespace App\Models\Factories;

use App\Models\CandidateLanguage;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobApplicationResume;
use App\Models\JobAssignedCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class JobApplicationResumeFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = JobApplicationResume::class;
    }


    /**
     * @param Model $objJobApplication
     * @return mixed
     */
    public function getByJobApplication(Model $objJobApplication)
    {
        return $this->model::where('job_application_id', '=', $objJobApplication->id)->get();
    }

    /**
     * @param Model $objJobApplication
     * @return void
     */
    public function clearByJobApplication(Model $objJobApplication){

        $arrItems = $this->getByJobApplication($objJobApplication);
        if($arrItems){
            foreach ($arrItems as $key => $obj){
                $obj->delete();
            }
        }
    }


    /**
     * @param Model $objJobApplication
     * @param array $arrData
     * @return bool
     */
    public function createOrUpdate(Model $objJobApplication, array $arrData): bool
    {
        $this->clearByJobApplication($objJobApplication);

        foreach ($arrData as $key => $item){

            $obj = new JobApplicationResume();
            $obj->setJobApplicationId($objJobApplication->getId());
            $obj->setMediaId($item['resume_id']);

            if(!$obj->save()){
                return false;
            }

        }
        return true;
    }

}
