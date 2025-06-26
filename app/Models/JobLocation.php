<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $job_id
 * @property int $city_id
 * @property int $postcode_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class JobLocation extends Model
{
    use HasFactory;

    public $table = 'job_locations';
    protected $with = ['city'];

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function job(){
        return $this->belongsTo(Job::class);
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
    public function getJobId(): int
    {
        return $this->job_id;
    }

    /**
     * @param int $job_id
     */
    public function setJobId(int $job_id): void
    {
        $this->job_id = $job_id;
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
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return int
     */
    public function getPostcodeId()
    {
        return $this->postcode_id;
    }

    /**
     * @param int $postcode_id
     */
    public function setPostcodeId($postcode_id)
    {
        $this->postcode_id = $postcode_id;
    }



}
