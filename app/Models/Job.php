<?php

namespace App\Models;

use App\Http\Livewire\DegreeLevel;
use App\Models\Factories\MediaFactory;
use App\Rules\JobRequirementValidator;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * App\Models\Job
 *
 * @property int $id
 * @property string $job_id
 * @property string $job_title
 * @property string $position
 * @property string|null $advantages
 * @property string|null $tasks
 * @property string $suspended
 * @property string $perks
 * @property string $description
 * @property string $candidate_count
 * @property int $is_anonym
 * @property int $company_id
 * @property int $is_created_by_admin
 * @property int $status
 * @property string $job_release_date // erbenyesseg $job_release_date- $job_expiry_date
 * @property string $job_expiry_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Job extends Model
{
    use LogsActivity;

    protected $with = ['jobLocations', 'jobCategory', 'activeFeatured','jobApplications','company'];

    const IS_SUSPENDED = [
        1 => 'Yes',
        0 => 'No',
    ];

    const IS_FEATURED = [
        1 => 'Yes',
        0 => 'No',
    ];

    const STATUS_DRAFT = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_SUSPENDED = 4;
    const STATUS_EXPIRED = 5;
    const STATUS_ADMIN_DECLINED = 6;

    const EDITABLE_STATUSES = [0,1,2];

    const STATUS = [
        0 => 'Drafted',
        1 => 'Pending',
        2 => 'Approved',
        3 => 'Active',
        4 => 'Suspended',
        5 => 'Expired',
        6 => 'Admin_declined',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success',
        2 => 'danger',
        3 => 'primary',
        4 => 'danger',
        5 => 'primary',
        6 => 'danger',
    ];

    const IS_FREELANCER = [
        1 => 'Yes',
        0 => 'No',
    ];

    const JOBS_ACTIVE = [
        0 => 'Active',
        1 => 'Expire',
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    public $table = 'jobs';

    public $fillable = [
        'job_id',
        'job_title',
        'company_id',
        'description',
        'advantages',
        'tasks',
        'is_suspended',
        'perks',
        'position',
        'candidate_count',
        'job_expiry_date',
        'job_release_date',
        'is_anonym',
        'status',
        'is_created_by_admin'
    ];

    protected static $logName = 'Backoffice';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'job_id',
        'job_title',
        'company_id',
        'description',
        'advantages',
        'tasks',
        'perks',
        'position',
        'candidate_count',
        'job_expiry_date',
        'job_release_date',
        'is_anonym',
        'status',
        'is_created_by_admin'
    ];

    /**
     * @var array
     */




    public $distance;
    protected $appends = ['company','distance'];
    public function getDistance(){
        return $this->distance;
    }
    public function getDistanceAttribute(){
        return $this->distance;
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
    public function getJobId(): string
    {
        return $this->job_id;
    }

    /**
     * @param string $job_id
     */
    public function setJobId(string $job_id): void
    {
        $this->job_id = $job_id;
    }

    /**
     * @return string
     */
    public function getJobTitle(): string
    {
        return $this->job_title;
    }

    /**
     * @param string $job_title
     */
    public function setJobTitle(string $job_title): void
    {
        $this->job_title = $job_title;
    }


    public function getPosition()
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

    public function getAdvantages()
    {
        return $this->advantages;
    }

    /**
     * @param string|null $advantages
     */
    public function setAdvantages(?string $advantages): void
    {
        $this->advantages = $advantages;
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param string $tasks
     */
    public function setTasks(string $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function getPerks()
    {
        return $this->perks;
    }

    public function setPerks(?string $perks)
    {
        $this->perks = $perks;
    }

    public function getDescription()
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

    public function getCandidateCount()
    {
        return $this->candidate_count;
    }

    /**
     * @param string $candidate_count
     */
    public function setCandidateCount(string $candidate_count): void
    {
        $this->candidate_count = $candidate_count;
    }

    /**
     * @return int
     */
    public function getIsAnonym(): int
    {
        return $this->is_anonym;
    }

    /**
     * @param int $is_anonym
     */
    public function setIsAnonym(int $is_anonym): void
    {
        $this->is_anonym = $is_anonym;
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
     * @return int
     */
    public function getIsCreatedByAdmin(): int
    {
        return $this->is_created_by_admin;
    }

    /**
     * @param int $is_created_by_admin
     */
    public function setIsCreatedByAdmin(int $is_created_by_admin): void
    {
        $this->is_created_by_admin = $is_created_by_admin;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


    /**
     * @return int
     */
    public function getSuspended(): int
    {
        return $this->is_suspended;
    }

    /**
     * @param int $status
     */
    public function setSuspended(int $status): void
    {
        $this->is_suspended = $status;
    }

    public function getJobReleaseDate()
    {
        return $this->job_release_date;
    }

    /**
     * @param string $job_release_date
     */
    public function setJobReleaseDate(string $job_release_date): void
    {
        $this->job_release_date = $job_release_date;
    }

    public function getJobExpiryDate()
    {
        return $this->job_expiry_date;
    }

    /**
     * @param string $job_expiry_date
     */
    public function setJobExpiryDate(string $job_expiry_date): void
    {
        $this->job_expiry_date = $job_expiry_date;
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


    public function jobLocations()
    {
        return $this->hasMany(JobLocation::class,"job_id","id");
    }

    public function jobExp()
    {
        return $this->hasMany(JobLocation::class,"job_id","id");
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function jobShifts()
    {
        return $this->hasMany(JobAssignedShift::class);
    }


    public function jobTypes()
    {
        return $this->hasMany(JobAssignedType::class);
    }

    public function jobCategories()
    {
        return $this->hasMany(JobAssignedCategory::class);
    }


    public function jobEducationRequirements()
    {
        return $this->hasMany(JobEducation::class);
    }

    public function jobExperienceRequirements()
    {
        return $this->hasMany(JobExperience::class);
    }

    public function jobDrivingLicenseRequirements()
    {
        return $this->hasMany(JobDrivingLicense::class);
    }


    public function jobItSkillRequirements()
    {
        return $this->hasMany(JobItSkill::class);
    }

    public function jobSoftwareSkillRequirements()
    {
        return $this->hasMany(JobSoftwareSkill::class);
    }

    public function jobLanguageSkillRequirements()
    {
        return $this->hasMany(JobLanguageSkill::class);
    }

    public function jobPersonalSkillRequirements()
    {
        return $this->hasMany(JobPersonalSkill::class);
    }

    public function getJobRequirements(){
        return [
            'education' => $this->jobEducationRequirements(),
            'experience' => $this->jobExperienceRequirements(),
            'drivers_license' => $this->jobDrivingLicenseRequirements(),
            'it_skill' => $this->jobItSkillRequirements(),
            'software_skill' => $this->jobSoftwareSkillRequirements(),
            'language_skill' => $this->jobLanguageSkillRequirements(),
            'personal_skill' => $this->jobPersonalSkillRequirements(),
        ];
    }

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

    /**
     * @param  Builder  $query
     * @param  int  $status
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, $status)
    {
        return $query->where('status', $status);
    }
    /**
     * @return BelongsTo
     */
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function careerLevel()
    {
        return $this->belongsTo(CareerLevel::class, 'career_level_id');
    }

    /**
     * @return BelongsTo
     */
    public function functionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    /**
     * @return BelongsTo
     */
    public function jobShift()
    {
        return $this->belongsTo(JobShift::class, 'job_shift_id');
    }

    /**
     * @return BelongsTo
     */
    public function degreeLevel()
    {
        return $this->belongsTo(RequiredDegreeLevel::class, 'degree_level_id');
    }

    /**
     * @return BelongsToMany
     */
    public function jobsSkill()
    {
        return $this->belongsToMany(Skill::class, 'jobs_skill', 'job_id', 'skill_id');
    }

    /**
     * @return HasMany
     */
    public function appliedJobs()
    {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function jobEducations()
    {
        return $this->hasMany(JobEducation::class, 'job_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function jobsTag()
    {
        return $this->belongsToMany(Tag::class, 'jobs_tag', 'job_id', 'tag_id');
    }


    /**
     * @return BelongsTo
     */
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * @return string
     */
    public function getFullLocationAttribute()
    {
        $location = '';
        if (! empty($this->city)) {
            $location = $this->city->name.', ';
        }

        if (! empty($this->state)) {
            $location = $location.$this->state->name.', ';
        }

        if (! empty($this->country)) {
            $location = $location.$this->country->name;
        }

        return $location;
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

    public function getCompanyAttribute(){
        return Company::query()->where('id', $this->getCompanyId())->first();
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


}
