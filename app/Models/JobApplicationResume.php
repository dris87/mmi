<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property int $job_application_id
 * @property int $media_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class JobApplicationResume extends Model
{
    /**
     * @var array
     */

    protected $fillable = ['job_application_id', 'media_id'];
    protected $with = ['media','jobApplication'];
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media()
    {
        return $this->belongsTo(Media::class,'media_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class,'job_application_id');
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
    public function getJobApplicationId(): int
    {
        return $this->job_application_id;
    }

    /**
     * @param int $job_application_id
     */
    public function setJobApplicationId(int $job_application_id): void
    {
        $this->job_application_id = $job_application_id;
    }

    /**
     * @return int
     */
    public function getMediaId(): int
    {
        return $this->media_id;
    }

    /**
     * @param int $media_id
     */
    public function setMediaId(int $media_id): void
    {
        $this->media_id = $media_id;
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
