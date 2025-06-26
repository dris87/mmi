<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $job_id
 * @property int $driving_license_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobDrivingLicense extends Model
{
    use HasFactory;

    public $table = 'job_driving_licenses';

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
    public function getDrivingLicenseId(): int
    {
        return $this->driving_license_id;
    }

    /**
     * @param int $driving_license_id
     */
    public function setDrivingLicenseId(int $driving_license_id): void
    {
        $this->driving_license_id = $driving_license_id;
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

}
