<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $award_image
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyAward extends Model implements HasMedia
{
    use InteractsWithMedia;

    const AWARD_PATH = 'company_awards';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'description', 'award_image', 'created_at', 'updated_at'];

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
    public function getAwardImage(): string
    {
        return $this->getFirstMediaUrl(CompanyAward::AWARD_PATH);
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
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    public function getFormattedData(){
        $objMedia = $this->getMedia(CompanyAward::AWARD_PATH)->first();
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'image' => $this->getAwardImage(),
            'mediaId' => $objMedia ? $objMedia->id : null,
        ];
    }
}
