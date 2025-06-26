<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;

/**
 * Class Company
 *
 * @version June 22, 2020, 12:34 pm UTC
 * @property int $id
 * @property string $ceo
 * @property int $no_of_offices
 * @property int $industry_id
 * @property int $user_id
 * @property int $ownership_type_id
 * @property int $company_size_id
 * @property int $established_in
 * @property int $diff_mailing_address
 * @property string|null $details
 * @property string $street
 * @property string $name
 * @property string $representative
 * @property string $website
 * @property string $company_number
 * @property string $vatNumber
 * @property string $unique_id
 * @property string $location
 * @property string $location2
 * @property integer $postcode_id
 * @property integer $city_id
 * @property string|null $fax
 * @property boolean $is_deleted
 * @property integer $is_paper_invoice
 * @property string|null $display_name
 * @property string|null $introduction
 * @property string|null $mission
 * @property string|null $why_work_with_us
 * @property integer|null $company_size
 * @property integer|null $mailing_postcode_id
 * @property integer|null $mailing_city_id
 * @property string|null $mailing_address
 * @property string|null $mailing_street
 * @property string|null $mailing_floor
 * @property string|null $mailing_door
 * @property string|null $logo
 * @property string|null $cover_photo
 * @property string|null $workplace_image
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $linkedin_url
 * @property string|null $google_plus_url
 * @property string|null $pinterest_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CompanySize $companySize
 * @property-read Industry $industry
 * @property-read OwnerShipType $ownerShipType
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCeo($value)
 * @method static Builder|Company whereCompanySizeId($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDetails($value)
 * @method static Builder|Company whereEstablishedIn($value)
 * @method static Builder|Company whereFacebookUrl($value)
 * @method static Builder|Company whereFax($value)
 * @method static Builder|Company whereGooglePlusUrl($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereIndustryId($value)
 * @method static Builder|Company whereIsFeatured($value)
 * @method static Builder|Company whereLinkedinUrl($value)
 * @method static Builder|Company whereLocation($value)
 * @method static Builder|Company whereLocation2($value)
 * @method static Builder|Company whereNoOfOffices($value)
 * @method static Builder|Company whereOwnershipTypeId($value)
 * @method static Builder|Company wherePinterestUrl($value)
 * @method static Builder|Company whereTwitterUrl($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereWebsite($value)
 * @method static Builder|Company whereUniqueId($value)
 * @mixin Eloquent
 * @property-read User|null $user
 * @property-read mixed $company_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read int|null $jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUserId($value)
 * @property-read \App\Models\FeaturedRecord|null $activeFeatured
 * @property-read \App\Models\FeaturedRecord|null $featured
 * @property-read mixed $city_name
 * @property-read mixed $country_name
 * @property-read mixed $state_name
 */
class Company extends Model implements HasMedia
{
    use InteractsWithMedia;
    use LogsActivity;

    public $table = 'companies';

    public const COMPANY_LOGIN_TYPE = 0;
    public const ISACTIVE = 1;
    public const DEACTIVE = 0;

    public const LOGO = 'company_logos';
    public const COVER_PHOTO = 'company_covers';
    public const WORKPLACE_PHOTO = 'company_workplace';
    public const GALLERY_PATH = 'company_gallery';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['companyVideos', 'companyAwards', 'companySites', 'media'];

    const BTN_BTN_COLOR = [
        'btn btn-green btn-small-effect',
        'btn btn-purple btn-small btn-effect',
        'btn btn-blue btn-small btn-effect',
        'btn btn-orange btn-small btn-effect',
        'btn btn-red btn-small btn-effect',
        'btn btn-blue-grey btn-small btn-effect',
        'btn btn-green btn-small btn-effect',
    ];

    const IS_FEATURED = [
        1 => 'Yes',
        0 => 'No',
    ];

    const STATUS = [
        1 => 'Active',
        0 => 'Inactive',
    ];

    public $fillable = [
        'id',
        'postcode_id',
        'city_id',
        'street',
        'name',
        'representative',
        'diff_mailing_address',
        'vatNumber',
        'address',
        'floor',
        'door',
        'user_id',
        'unique_id',
        'display_name', 'representative', 'vatNumber', 'company_number',
        'street', 'floor', 'door', 'is_paper_invoice', 'mailing_postcode_id', 'mailing_city_id',
        'mailing_street','mailing_address', 'mailing_floor', 'mailing_door', 'website',
        'facebook_url', 'google_plus_url', 'linkedin_url', 'company_size', 'established_in',
        'industry_id', 'introduction', 'mission', 'why_work_with_us', 'user_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'postcode_id'   => 'required',
        'street'        =>'required',
        'city_id'       => 'required',
        'address'       => 'required',
        'name'          => 'required',
        'floor'         => 'nullable',
        'door'          => 'nullable',
    ];

    /**
     * @var array
     */
    protected $appends = ['company_url'];

    public function getCountryNameAttribute()
    {
        if (! empty($this->user->country)) {
            return $this->user->country->name;
        }
    }

    public function getStateNameAttribute()
    {
        if (! empty($this->user->state)) {
            return $this->user->state->name;
        }
    }

    public function getCityNameAttribute()
    {
        if (! empty($this->user->city)) {
            return $this->user->city->name;
        }
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }


    /**
     * @return mixed
     */
    public function getCompanyUrlAttribute()
    {
        /** @var Media $media */

        return asset('assets/img/employer-image.png');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function postalCode()
    {
        return $this->hasOne(PostalCode::class, 'id', 'postcode_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownerShipType()
    {
        return $this->hasOne(OwnerShipType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function companySize()
    {
        return $this->hasOne(CompanySize::class);
    }

    /**
     * @return HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function featured()
    {
        return $this->morphOne(FeaturedRecord::class, 'owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function activeFeatured()
    {
        return $this->morphOne(FeaturedRecord::class, 'owner')->where('end_time', '>', \Carbon\Carbon::now());
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'owner');
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
    public function getRepresentative(): string
    {
        return $this->representative;
    }

    /**
     * @param string $representative
     */
    public function setRepresentative(string $representative): void
    {
        $this->representative = $representative;
    }

    /**
     * @return int
     */
    public function getPostcodeId(): int
    {
        return $this->postcode_id;
    }

    /**
     * @param int $postcode_id
     */
    public function setPostcodeId(int $postcode_id): void
    {
        $this->postcode_id = $postcode_id;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->city_id;
    }

    /**
     * @param int $city_id
     */
    public function setCityId(int $city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return int
     */
    public function getIsPaperInvoice(): int
    {
        return $this->is_paper_invoice;
    }

    /**
     * @param int $is_paper_invoice
     */
    public function setIsPaperInvoice(int $is_paper_invoice): void
    {
        $this->is_paper_invoice = $is_paper_invoice;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    /**
     * @param string|null $display_name
     */
    public function setDisplayName(?string $display_name): void
    {
        $this->display_name = $display_name;
    }

    /**
     * @return string|null
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @param string|null $introduction
     */
    public function setIntroduction(?string $introduction): void
    {
        $this->introduction = $introduction;
    }

    /**
     * @return string|null
     */
    public function getMission(): ?string
    {
        return $this->mission;
    }

    /**
     * @param string|null $mission
     */
    public function setMission(?string $mission): void
    {
        $this->mission = $mission;
    }

    /**
     * @return string|null
     */
    public function getWhyWorkWithUs(): ?string
    {
        return $this->why_work_with_us;
    }

    /**
     * @param string|null $why_work_with_us
     */
    public function setWhyWorkWithUs(?string $why_work_with_us): void
    {
        $this->why_work_with_us = $why_work_with_us;
    }

    /**
     * @return int|null
     */
    public function getCompanySize(): ?int
    {
        return $this->company_size;
    }

    /**
     * @param int|null $company_size
     */
    public function setCompanySize(?int $company_size): void
    {
        $this->company_size = $company_size;
    }

    /**
     * @return int|null
     */
    public function getMailingPostcodeId(): ?int
    {
        return $this->mailing_postcode_id;
    }

    /**
     * @param int|null $mailing_postcode_id
     */
    public function setMailingPostcodeId(?int $mailing_postcode_id): void
    {
        $this->mailing_postcode_id = $mailing_postcode_id;
    }

    /**
     * @return int|null
     */
    public function getMailingCityId(): ?int
    {
        return $this->mailing_city_id;
    }

    /**
     * @param int|null $mailing_city_id
     */
    public function setMailingCityId(?int $mailing_city_id): void
    {
        $this->mailing_city_id = $mailing_city_id;
    }

    /**
     * @return string|null
     */
    public function getMailingAddress(): ?string
    {
        return $this->mailing_address;
    }

    /**
     * @param string|null $mailing_address
     */
    public function setMailingAddress(?string $mailing_address): void
    {
        $this->mailing_address = $mailing_address;
    }

    /**
     * @return string|null
     */
    public function getMailingStreet(): ?string
    {
        return $this->mailing_street;
    }

    /**
     * @param string|null $mailing_street
     */
    public function setMailingStreet(?string $mailing_street): void
    {
        $this->mailing_street = $mailing_street;
    }

    /**
     * @return string|null
     */
    public function getMailingFloor(): ?string
    {
        return $this->mailing_floor;
    }

    /**
     * @param string|null $mailing_floor
     */
    public function setMailingFloor(?string $mailing_floor): void
    {
        $this->mailing_floor = $mailing_floor;
    }

    /**
     * @return string|null
     */
    public function getMailingDoor(): ?string
    {
        return $this->mailing_door;
    }

    /**
     * @param string|null $mailing_door
     */
    public function setMailingDoor(?string $mailing_door): void
    {
        $this->mailing_door = $mailing_door;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->getFirstMediaUrl(Company::LOGO);
    }
    /**
     * @return string
     */
    public function getCoverPhoto(): string
    {
        return $this->getFirstMediaUrl(Company::COVER_PHOTO);
    }

    /**
     * @return string
     */
    public function getWorkplaceImage(): string
    {
        return $this->getFirstMediaUrl(Company::WORKPLACE_PHOTO);
    }

    /**
     * @return string|null
     */
    public function getFacebookUrl(): ?string
    {
        return $this->facebook_url;
    }

    /**
     * @param string|null $facebook_url
     */
    public function setFacebookUrl(?string $facebook_url): void
    {
        $this->facebook_url = $facebook_url;
    }

    /**
     * @return string|null
     */
    public function getLinkedinUrl(): ?string
    {
        return $this->linkedin_url;
    }

    /**
     * @param string|null $linkedin_url
     */
    public function setLinkedinUrl(?string $linkedin_url): void
    {
        $this->linkedin_url = $linkedin_url;
    }

    /**
     * @return string|null
     */
    public function getGooglePlusUrl(): ?string
    {
        return $this->google_plus_url;
    }

    /**
     * @param string|null $google_plus_url
     */
    public function setGooglePlusUrl(?string $google_plus_url): void
    {
        $this->google_plus_url = $google_plus_url;
    }

    /**
     * @return HasMany
     */
    public function companyVideos(): HasMany
    {
        return $this->hasMany(CompanyVideo::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    public function companyAwards(): HasMany
    {
        return $this->hasMany(CompanyAward::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    public function companySites(): HasMany
    {
        return $this->hasMany(CompanySite::class, 'company_id');
    }

    public function getCompanyGallery(): Collection
    {
        return $this->getMedia(Company::GALLERY_PATH);
    }

    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $isDeleted)
    {
        $this->is_deleted = $isDeleted;
    }

    /**
     * @return int
     */
    public function getDiffMailingAddress(): int
    {
        return $this->diff_mailing_address;
    }

    /**
     * @param int $diff_mailing_address
     */
    public function setDiffMailingAddress(int $diff_mailing_address): void
    {
        $this->diff_mailing_address = $diff_mailing_address;
    }


}
