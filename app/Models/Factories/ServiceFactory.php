<?php


namespace App\Models\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * BaseFactory
 */
class ServiceFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Service::class;
    }

    /**
     * @param string $name
     * @param float $price
     * @return Service|false
     */
    public function create(string $name, float $price){
        $objService = new Service();
        $objService->setName($name);
        $objService->setPrice($price);

        if(!$objService->save()){
            return false;
        }

        return $objService;
    }
}
