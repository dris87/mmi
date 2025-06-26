<?php


namespace App\Models\Factories;

use App\Models\City;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;

/**
 * BaseFactory
 */
class SettingsFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Setting::class;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|mixed|Setting
     */
    public function getById($id){

        return $this->model::query()->where("id",$id)->first();
    }

    /**
     * @param $key
     * @return mixed|Setting
     */
    public function getByKey($key){

        return $this->model::query()->where("key",$key)->first();
    }
}
