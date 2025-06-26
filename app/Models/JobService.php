<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $job_id
 * @property integer $service_id
 * @property string $created_at
 * @property string $expires_at
 * @property Job $job
 * @property Service $service
 */
class JobService extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const UPDATED_AT = '';

    /**
     * @var array
     */
    protected $fillable = ['job_id', 'service_id', 'created_at', 'expires_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }

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
    public function getServiceId(): int
    {
        return $this->service_id;
    }

    /**
     * @param int $service_id
     */
    public function setServiceId(int $service_id): void
    {
        $this->service_id = $service_id;
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
    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }

    /**
     * @param string $expires_at
     */
    public function setExpiresAt(string $expires_at): void
    {
        $this->expires_at = $expires_at;
    }


}
