<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $plan_id
 * @property integer $service_id
 * @property string $created_at
 * @property string $updated_at
 * @property Plan $plan
 * @property Service $service
 */
class PlanService extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['plan_id', 'service_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
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
    public function getPlanId(): int
    {
        return $this->plan_id;
    }

    /**
     * @param int $plan_id
     */
    public function setPlanId(int $plan_id): void
    {
        $this->plan_id = $plan_id;
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
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }


}
