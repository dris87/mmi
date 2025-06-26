<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $job_id
 * @property string $form_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobChange extends Model
{
    use HasFactory;

    public $table = 'job_change';

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
    public function getFormData(): string
    {
        return $this->form_data;
    }

    /**
     * @param string $form_data
     */
    public function setFormData(string $form_data): void
    {
        $this->form_data = $form_data;
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
