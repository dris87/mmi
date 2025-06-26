<?php


namespace App\Models\Factories;

use App\Models\City;
use App\Models\PostalCode;
use App\Models\State;
use App\Models\User;

/**
 * BaseFactory
 */
class PostalCodeFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = PostalCode::class;
    }

    /**
     * @param string $postcode
     * @return null|PostalCode
     */
    public function getByPostalCode(string $postcode)
    {
        return $this->model::where('postal_code', $postcode)->first();
    }

    /**
     * @param string $postcode
     * @return null|PostalCode
     */
    public function getByCityId( $city_id)
    {
        return $this->model::where('city_id', $city_id)->first();
    }

}
