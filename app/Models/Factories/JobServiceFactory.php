<?php


namespace App\Models\Factories;

use App\Models\Job;
use App\Models\JobService;
use App\Models\Service;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * BaseFactory
 */
class JobServiceFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = JobService::class;
    }

    /**
     * @param Job $objJob
     * @param Service $objService
     * @param DateTime|null $expiresAt
     * @return JobService|false
     */
    public function create(Job $objJob, Service $objService, DateTime $expiresAt = null){
        $objJobService = new JobService();
        $objJobService->setJobId($objJob->getId());
        $objJobService->setServiceId($objService->getId());
        if($expiresAt) {
            $objJobService->setExpiresAt($expiresAt->format('Y-m-d H:i:s'));
        }

        if(!$objJobService->save()){
            return false;
        }

        return $objJobService;
    }
}
