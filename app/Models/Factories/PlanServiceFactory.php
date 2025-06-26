<?php


namespace App\Models\Factories;

use App\Models\Plan;
use App\Models\PlanService;
use App\Models\Service;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * BaseFactory
 */
class PlanServiceFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = PlanService::class;
    }

    /**
     * @param Plan $objPlan
     * @param Service $objService
     * @return PlanService|false
     */
    public function create(Plan $objPlan, Service $objService){
        $objPlanService = new PlanService();
        $objPlanService->setPlanId($objPlan->getId());
        $objPlanService->setServiceId($objService->getId());

        if(!$objPlanService->save()){
            return false;
        }

        return $objPlanService;
    }
}
