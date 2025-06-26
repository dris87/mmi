<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property integer $id
 * @property integer $company_id
 * @property string $title
 * @property string $description
 * @property string $video_url
 * @property string $embed_url
 * @property string $thumbnail
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyVideo extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const VIDEO_THUMBNAIL = 'video_thumbnail';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'title', 'description', 'thumbnail', 'embed_url', 'video_url', 'created_at', 'updated_at'];

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getVideoUrl(): string
    {
        return $this->video_url;
    }

    /**
     * @param string $video_url
     */
    public function setVideoUrl(string $video_url): void
    {
        $this->video_url = $video_url;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->getFirstMediaUrl(CompanyVideo::VIDEO_THUMBNAIL);
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string|null
     */
    public function getEmbedUrl(): ?string
    {
        return $this->embed_url;
    }

    /**
     * @param string $embed_url
     */
    public function setEmbedUrl(string $embed_url): void
    {
        $this->embed_url = $embed_url;
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getFormattedData(){
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'video_url' => $this->getVideoUrl(),
            'embed_url' => $this->getEmbedUrl(),
            'thumbnail' => $this->getThumbnail(),
        ];
    }
}
