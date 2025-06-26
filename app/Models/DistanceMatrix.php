<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  $id
 * @property  $postal_code_from
 * @property  $postal_code_to
 * @property  $distance
 */
class DistanceMatrix extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distance_matrix';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['postal_code_from', 'postal_code_to', 'distance'];

    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  $id
     */
    public function setId( $id)
    {
        $this->id = $id;
    }

    /**
     * @return
     */
    public function getPostalCodeFrom()
    {
        return $this->postal_code_from;
    }

    /**
     * @param  $postal_code_from
     */
    public function setPostalCodeFrom($postal_code_from)
    {
        $this->postal_code_from = $postal_code_from;
    }

    /**
     * @return
     */
    public function getPostalCodeTo()
    {
        return $this->postal_code_to;
    }

    /**
     * @param  $postal_code_to
     */
    public function setPostalCodeTo($postal_code_to)
    {
        $this->postal_code_to = $postal_code_to;
    }

    /**
     * @return
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param  $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }
}
