<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $job_id
 * @property string $position
 * @property string years
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobExperience extends Model
{
    use HasFactory;

    public $table = 'job_experiences';

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
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getYears(): string
    {
        return $this->years;
    }

    /**
     * @param string $years
     */
    public function setYears(string $years): void
    {
        $this->years = $years;
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
