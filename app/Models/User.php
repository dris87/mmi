<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use App\Notifications\UserVerifyNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $phone
 * @property Carbon|null $email_verified_at
 * @property string $last_login
 * @property string $password
 * @property string|null $dob
 * @property int|null $gender
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property int $is_active
 * @property int $is_verified
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Candidate|null $candidate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $candidateSkill
 * @property-read int|null $candidate_skill_count
 * @property-read mixed $avatar
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereState($value)
 * @property-read \App\Models\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Language[] $candidateLanguage
 * @property-read int|null $candidate_language_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLanguage($value)
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int $profile_views
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavouriteCompany[] $followings
 * @property-read int|null $followings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfileViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStateId($value)
 * @property-read mixed $city_name
 * @property-read mixed $country_name
 * @property-read string|null $position
 * @property-read mixed $state_name
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $linkedin_url
 * @property string|null $google_plus_url
 * @property string|null $pinterest_url
 * @property string|null $stripe_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGooglePlusUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLinkedinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePinterestUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTwitterUrl($value)
 * @property string|null $region_code
 * @property-read bool $is_online_profile_availbal
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegionCode($value)
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Notifiable, HasRoles, InteractsWithMedia, Billable;
    use LogsActivity;
    use SoftDeletes;

    protected static $logFillable = true;

    const PROFILE = 'profile-pictures';

    const LANGUAGES = [
        'ar' => 'Arabic',
        'zh' => 'Chinese',
        'en' => 'English',
        'fr' => 'French',
        'de' => 'German',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'es' => 'Spanish',
        'tr' => 'Turkish',
        'hu' => 'Magyar',

    ];

    const LANGUAGES_IMAGE = [
        'en' => 'assets/img/united-states.svg',
        'es' => 'assets/img/spain.svg',
        'fr' => 'assets/img/france.svg',
        'de' => 'assets/img/germany.svg',
        'ru' => 'assets/img/russia.svg',
        'pt' => 'assets/img/portugal.svg',
        'ar' => 'assets/img/iraq.svg',
        'zh' => 'assets/img/china.svg',
        'tr' => 'assets/img/turkey.svg',
        'hu' => 'assets/img/turkey.svg',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'position',
        'position_id',
        'dob',
        'gender',
        'country_id',
        'state_id',
        'city_id',
        'is_active',
        'is_verified',
        'phone',
        'email_verified_at',
        'owner_id',
        'owner_type',
        'language',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'google_plus_url',
        'pinterest_url',
        'region_code',
    ];

    protected static $logAttributes = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'gender',
        'country_id',
        'state_id',
        'city_id',
        'is_active',
        'is_verified',
        'phone',
        'email_verified_at',
        'owner_id',
        'owner_type',
        'language',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'google_plus_url',
        'pinterest_url',
        'region_code'];

    /**
     * @var array
     */
    protected $appends = ['full_name', 'avatar', 'country_name', 'state_name', 'city_name'];

    protected $with = ['media', 'country', 'city', 'state'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function backofficeUser()
    {
        return $this->hasOne(BackofficeUser::class, 'user_id');
    }

    public function isBackofficeUser()
    {
        return !is_null($this->backofficeUser);
    }

    public function getCountryNameAttribute()
    {
        if (! empty($this->country)) {
            return $this->country->name;
        }
    }

    public function getStateNameAttribute()
    {
        if (! empty($this->state)) {
            return $this->state->name;
        }
    }

    public function getCityNameAttribute()
    {
        if (! empty($this->city)) {
            return $this->city->name;
        }
    }

    /**
     * @return mixed
     */
    public function getAvatarAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PROFILE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/main-logo.png');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    public static $messages = [
        'email.regex' => 'Please enter valid email.',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    /**
     * @return HasOne
     */
    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function companyUser()
    {
        return $this->hasMany(CompanyUser::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateSkill()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills', 'user_id', 'skill_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateLanguage()
    {
        return $this->belongsToMany(Language::class, 'candidate_language', 'user_id', 'language_id');
    }

    /**
     * @return HasMany
     */
    public function followings()
    {
        return $this->hasMany(FavouriteCompany::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function getIsOnlineProfileAvailbalAttribute()
    {
        if (empty($this->facebook_url) && empty($this->twitter_url) && empty($this->linkedin_url) && empty($this->google_plus_url) && empty($this->pinterest_url)) {
            return false;
        }

        return true;
    }

    public function sendEmailVerificationNotification()
    {
        $verifyEmail = new UserVerifyNotification($this);
        $send = $verifyEmail->toMail($this);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $PasswordReset = new PasswordReset($token, $this);
        $send = $PasswordReset->toMail($token, $this);
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
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Carbon|null
     */
    public function getEmailVerifiedAt(): ?Carbon
    {
        return $this->email_verified_at;
    }

    /**
     * @param Carbon|null $email_verified_at
     */
    public function setEmailVerifiedAt(?Carbon $email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * @return string|null
     */
    public function getDob(): ?string
    {
        return $this->dob;
    }

    /**
     * @param string|null $dob
     */
    public function setDob(?string $dob): void
    {
        $this->dob = $dob;
    }

    /**
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int|null $gender
     */
    public function setGender(?int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getIsActive(): int
    {
        return $this->is_active;
    }

    /**
     * @param int $is_active
     */
    public function setIsActive(int $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return int
     */
    public function getIsVerified(): int
    {
        return $this->is_verified;
    }

    /**
     * @param int $is_verified
     */
    public function setIsVerified(int $is_verified): void
    {
        $this->is_verified = $is_verified;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    /**
     * @param int|null $owner_id
     */
    public function setOwnerId(?int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return string|null
     */
    public function getOwnerType(): ?string
    {
        return $this->owner_type;
    }

    /**
     * @param string|null $owner_type
     */
    public function setOwnerType(?string $owner_type): void
    {
        $this->owner_type = $owner_type;
    }

    /**
     * @return string|null
     */
    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }


    /**
     * @return Carbon|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param Carbon|null $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Candidate|null
     */
    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    /**
     * @param Candidate|null $candidate
     */
    public function setCandidate(?Candidate $candidate): void
    {
        $this->candidate = $candidate;
    }

    /**
     * @return Skill[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCandidateSkill()
    {
        return $this->candidateSkill;
    }

    /**
     * @param Skill[]|\Illuminate\Database\Eloquent\Collection $candidateSkill
     */
    public function setCandidateSkill($candidateSkill): void
    {
        $this->candidateSkill = $candidateSkill;
    }

    /**
     * @return int|null
     */
    public function getCandidateSkillCount(): ?int
    {
        return $this->candidate_skill_count;
    }

    /**
     * @param int|null $candidate_skill_count
     */
    public function setCandidateSkillCount(?int $candidate_skill_count): void
    {
        $this->candidate_skill_count = $candidate_skill_count;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName(string $full_name): void
    {
        $this->full_name = $full_name;
    }



    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
     */
    public function setMedia($media): void
    {
        $this->media = $media;
    }


    /**
     * @param int|null $media_count
     */
    public function setMediaCount(?int $media_count): void
    {
        $this->media_count = $media_count;
    }

    /**
     * @return int|null
     */
    public function getNotificationsCount(): ?int
    {
        return $this->notifications_count;
    }

    /**
     * @param int|null $notifications_count
     */
    public function setNotificationsCount(?int $notifications_count): void
    {
        $this->notifications_count = $notifications_count;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
     */
    public function setPermissions($permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return int|null
     */
    public function getPermissionsCount(): ?int
    {
        return $this->permissions_count;
    }

    /**
     * @param int|null $permissions_count
     */
    public function setPermissionsCount(?int $permissions_count): void
    {
        $this->permissions_count = $permissions_count;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return int|null
     */
    public function getRolesCount(): ?int
    {
        return $this->roles_count;
    }

    /**
     * @param int|null $roles_count
     */
    public function setRolesCount(?int $roles_count): void
    {
        $this->roles_count = $roles_count;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     */
    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return Language[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCandidateLanguage()
    {
        return $this->candidateLanguage;
    }

    /**
     * @param Language[]|\Illuminate\Database\Eloquent\Collection $candidateLanguage
     */
    public function setCandidateLanguage($candidateLanguage): void
    {
        $this->candidateLanguage = $candidateLanguage;
    }

    /**
     * @return int|null
     */
    public function getCandidateLanguageCount(): ?int
    {
        return $this->candidate_language_count;
    }

    /**
     * @param int|null $candidate_language_count
     */
    public function setCandidateLanguageCount(?int $candidate_language_count): void
    {
        $this->candidate_language_count = $candidate_language_count;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    /**
     * @param int|null $country_id
     */
    public function setCountryId(?int $country_id): void
    {
        $this->country_id = $country_id;
    }

    /**
     * @return int|null
     */
    public function getStateId(): ?int
    {
        return $this->state_id;
    }

    /**
     * @param int|null $state_id
     */
    public function setStateId(?int $state_id): void
    {
        $this->state_id = $state_id;
    }

    /**
     * @return int|null
     */
    public function getCityId(): ?int
    {
        return $this->city_id;
    }

    /**
     * @param int|null $city_id
     */
    public function setCityId(?int $city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return int
     */
    public function getProfileViews(): int
    {
        return $this->profile_views;
    }

    /**
     * @param int $profile_views
     */
    public function setProfileViews(int $profile_views): void
    {
        $this->profile_views = $profile_views;
    }

    /**
     * @return FavouriteCompany[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getFollowings()
    {
        return $this->followings;
    }

    /**
     * @param FavouriteCompany[]|\Illuminate\Database\Eloquent\Collection $followings
     */
    public function setFollowings($followings): void
    {
        $this->followings = $followings;
    }

    /**
     * @return int|null
     */
    public function getFollowingsCount(): ?int
    {
        return $this->followings_count;
    }

    /**
     * @param int|null $followings_count
     */
    public function setFollowingsCount(?int $followings_count): void
    {
        $this->followings_count = $followings_count;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * @param mixed $city_name
     */
    public function setCityName($city_name): void
    {
        $this->city_name = $city_name;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->country_name;
    }

    /**
     * @param mixed $country_name
     */
    public function setCountryName($country_name): void
    {
        $this->country_name = $country_name;
    }

    /**
     * @return mixed
     */
    public function getStateName()
    {
        return $this->state_name;
    }

    /**
     * @param mixed $state_name
     */
    public function setStateName($state_name): void
    {
        $this->state_name = $state_name;
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
    public function getTwitterUrl(): ?string
    {
        return $this->twitter_url;
    }

    /**
     * @param string|null $twitter_url
     */
    public function setTwitterUrl(?string $twitter_url): void
    {
        $this->twitter_url = $twitter_url;
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
     * @return string|null
     */
    public function getPinterestUrl(): ?string
    {
        return $this->pinterest_url;
    }

    /**
     * @param string|null $pinterest_url
     */
    public function setPinterestUrl(?string $pinterest_url): void
    {
        $this->pinterest_url = $pinterest_url;
    }

    /**
     * @return string|null
     */
    public function getStripeId(): ?string
    {
        return $this->stripe_id;
    }

    /**
     * @param string|null $stripe_id
     */
    public function setStripeId(?string $stripe_id): void
    {
        $this->stripe_id = $stripe_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[]
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
     */
    public function setSubscriptions($subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return int|null
     */
    public function getSubscriptionsCount(): ?int
    {
        return $this->subscriptions_count;
    }

    /**
     * @param int|null $subscriptions_count
     */
    public function setSubscriptionsCount(?int $subscriptions_count): void
    {
        $this->subscriptions_count = $subscriptions_count;
    }

    /**
     * @return string|null
     */
    public function getRegionCode(): ?string
    {
        return $this->region_code;
    }

    /**
     * @param string|null $region_code
     */
    public function setRegionCode(?string $region_code): void
    {
        $this->region_code = $region_code;
    }

    /**
     * @return bool
     */
    public function isIsOnlineProfileAvailbal(): bool
    {
        return $this->is_online_profile_availbal;
    }

    /**
     * @param bool $is_online_profile_availbal
     */
    public function setIsOnlineProfileAvailbal(bool $is_online_profile_availbal): void
    {
        $this->is_online_profile_availbal = $is_online_profile_availbal;
    }

    /**
     * @return string
     */
    public function getLastLogin(): string
    {
        return $this->last_login;
    }

    /**
     * @param string $last_login
     */
    public function setLastLogin(string $last_login): void
    {
        $this->last_login = $last_login;
    }




}
