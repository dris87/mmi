<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @property int $id
 * @property int $job_id
 * @property string $language_id
 * @property int $language_level_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobLanguageSkill extends Model
{
    use HasFactory;

    public $table = 'job_language_skills';

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
    public function getLanguageId(): string
    {
        return $this->language_id;
    }

    /**
     * @param string $language_id
     */
    public function setLanguageId(string $language_id): void
    {
        $this->language_id = $language_id;
    }

    /**
     * @return int
     */
    public function getLanguageLevelId(): int
    {
        return $this->language_level_id;
    }

    /**
     * @param int $language_level_id
     */
    public function setLanguageLevelId(int $language_level_id): void
    {
        $this->language_level_id = $language_level_id;
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
