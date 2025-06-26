<?php

namespace App\Models;

use App\Models\Factories\CityFactory;
use App\Models\Factories\PostalCodeFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $company_id
 * @property integer $postcode_id
 * @property integer $city_id
 * @property string $street
 * @property string $address
 * @property string|null $floor
 * @property string|null $door
 * @property string $created_at
 * @property string $updated_at
 */
class CompanySite extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'postcode_id', 'city_id', 'street', 'address', 'floor', 'door', 'created_at', 'updated_at'];

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId(int $company_id): void
    {
        $this->company_id = $company_id;
    }
    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @return int
     */
    public function getPostcodeId(): int
    {
        return $this->postcode_id;
    }

    /**
     * @param int $postcode_id
     */
    public function setPostcodeId(int $postcode_id): void
    {
        $this->postcode_id = $postcode_id;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->city_id;
    }

    /**
     * @param int $city_id
     */
    public function setCityId(int $city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return ?string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return ?string
     */
    public function getFloor(): ?string
    {
        return $this->floor;
    }


    public function setFloor($floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @return string
     */
    public function getDoor(): string
    {
        return $this->door;
    }

    public function setDoor($door): void
    {
        $this->door = $door;
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getFormattedData(){
        $postcode = (new PostalCodeFactory())->getById($this->getPostcodeId());
        $city = (new CityFactory())->getById($this->getCityId());
        return [
            'postcode' => $postcode ? $postcode->getPostalCode() : null,
            'city'  => $city ? $city->getName() : null,
            'street' => $this->getStreet(),
            'address' => $this->getAddress(),
            'floor' => $this->getFloor(),
            'door' => $this->getDoor(),
        ];
    }


}
