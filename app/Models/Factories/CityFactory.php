<?php


namespace App\Models\Factories;

use App\Models\City;
use App\Models\State;
use App\Models\User;

/**
 * BaseFactory
 */
class CityFactory extends BaseFactory
{

    public function __construct()
    {
        $this->model = City::class;
    }

    public function getByName($name){

        return $this->model::where("name",$name)->first();
    }

    public function createIfNotExist($name){

        $objCity = $this->getByName($name);

        if($objCity){
            return $objCity;
        }

        $objCity = new City();
        $objCity->name = $name;
        $objCity->state_id= State::DEFAULT_STATE;

        if(!$objCity->save()){
            return  false;
        }

        return $objCity;

    }
}
