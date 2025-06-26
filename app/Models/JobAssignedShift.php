<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $job_id
 * @property int $job_shift_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobAssignedShift extends Model
{

    use HasFactory;

    public $table = 'job_assigned_shifts';

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
    public function getJobShiftId(): int
    {
        return $this->job_shift_id;
    }

    /**
     * @param int $job_shift_id
     */
    public function setJobShiftId(int $job_shift_id): void
    {
        $this->job_shift_id = $job_shift_id;
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
