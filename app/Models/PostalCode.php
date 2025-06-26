<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * @property int $id
 * @property integer $city_id
 * @property int $postal_code
 * @property string $lat
 * @property string $long
 * @property string $town
 */
class PostalCode extends Model
{
    use LogsActivity;
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['city_id', 'postal_code', 'town'];
    protected static $logAttributes = ['city_id', 'postal_code', 'town'];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param int $city_id
     */
    public function setCityId(int $city_id)
    {
        $this->city_id = $city_id;
    }

    /**
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param int $postal_code
     */
    public function setPostalCode(int $postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     */
    public function setTown(string $town)
    {
        $this->town = $town;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat( $lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param string $long
     */
    public function setLong( $long)
    {
        $this->long = $long;
    }




}
