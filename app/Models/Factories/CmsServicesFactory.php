<?php


namespace App\Models\Factories;

use App\Models\City;
use App\Models\CmsServices;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;

/**
 * BaseFactory
 */
class CmsServicesFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CmsServices::class;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|mixed|CmsServices
     */
    public function getById($id){

        return $this->model::query()->where("id",$id)->first();
    }

    /**
     * @param $key
     * @return mixed|CmsServices
     */
    public function getByKey($key){

        return $this->model::query()->where("key",$key)->first();
    }
}
