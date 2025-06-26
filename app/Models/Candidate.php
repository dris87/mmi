<?php

namespace App\Models;

use App\Models\Factories\MediaFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Candidate
 *
 * @version July 20, 2020, 5:48 am UTC
 * @property int $id
 * @property int $user_id
 * @property string $unique_id
 * @property string|null $father_name
 * @property int $marital_status_id
 * @property string|null $nationality
 * @property string|null $national_id_card
 * @property int|null $experience
 * @property int|null $career_level_id
 * @property int|null $industry_id
 * @property int|null $candidate_status_id
 * @property int|null $functional_area_id
 * @property float|null $current_salary
 * @property float|null $expected_salary
 * @property float|null $expected_salary_to
 * @property string|null $salary_currency
 * @property string|null $address
 * @property int $city_id
 * @property int $postcode_id
 * @property string $personal_competencies
 * @property string $hobbies
 * @property integer $travel_anywhere
 * @property integer $travel_max_distance
 * @property integer $move_anywhere
 * @property int $immediate_available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CareerLevel|null $careerLevel
 * @property-read FunctionalArea|null $functionalArea
 * @property-read Industry|null $industry
 * @property-read MaritalStatus $maritalStatus
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @property-read mixed $candidate_url
 * @method static Builder|Candidate newModelQuery()
 * @method static Builder|Candidate newQuery()
 * @method static Builder|Candidate query()
 * @method static Builder|Candidate whereAddress($value)
 * @method static Builder|Candidate whereCareerLevelId($value)
 * @method static Builder|Candidate whereCreatedAt($value)
 * @method static Builder|Candidate whereCurrentSalary($value)
 * @method static Builder|Candidate whereExpectedSalary($value)
 * @method static Builder|Candidate whereExperience($value)
 * @method static Builder|Candidate whereFatherName($value)
 * @method static Builder|Candidate whereFunctionalAreaId($value)
 * @method static Builder|Candidate whereId($value)
 * @method static Builder|Candidate whereImmediateAvailable($value)
 * @method static Builder|Candidate whereIndustryId($value)
 * @method static Builder|Candidate whereMaritalStatusId($value)
 * @method static Builder|Candidate whereNationalIdCard($value)
 * @method static Builder|Candidate whereNationality($value)
 * @method static Builder|Candidate whereSalaryCurrency($value)
 * @method static Builder|Candidate whereUpdatedAt($value)
 * @method static Builder|Candidate whereUserId($value)
 * @method static Builder|Candidate whereUniqueId($value)
 * @mixin Eloquent
 * @property int $job_alert
 * @property-read mixed $city_name
 * @property-read mixed $country_name
 * @property-read string $full_location
 * @property-read mixed $state_name
 * @property-read Collection|\App\Models\JobType[] $jobAlerts
 * @property-read int|null $job_alerts_count
 * @property-read Collection|\App\Models\JobApplication[] $jobApplications
 * @property-read int|null $job_applications_count
 * @property-read Collection|\App\Models\JobApplication[] $penddingJobApplications
 * @property-read int|null $pendding_job_applications_count
 * @method static Builder|Candidate whereJobAlert($value)
 * @property string|null $available_at
 * @method static Builder|Candidate whereAvailableAt($value)
 */
class Candidate extends Model implements HasMedia
{
    use LogsActivity;
    use InteractsWithMedia;

    public $table = 'candidates';

    const RESUME_PATH = 'resumes';
    const CANDIDATE_DOCUMENT_PATH = 'documents';
    public const CANDIDATE_LOGIN_TYPE = 1;

    const STATUS = [
        1 => 'Active',
        0 => 'Deactive',
    ];
    const IMMEDIATE_AVAILABLE = [
        1 => 'Immediate Available',
        0 => 'Not Immediate Available',
    ];

    public static $attributeTranslation = [
        'expected_salary' => "Bérigény tól",
        'expected_salary_to' => "Bérigény ig"
    ];

    public $fillable = [
        'user_id',
        'unique_id',
        'travel_max_distance',
        'marital_status_id',
        'nationality',
        'gender',
        'candidate_status_id',
        'move_anywhere',
        'expected_salary',
        'expected_salary_to',
        'city_id',
        'postcode_id',
        'address',
        'immediate_available',
        'available_at',
    ];

    protected static $logAttributes = [
        'user_id',
        'travel_max_distance',
        'father_name',
        'marital_status_id',
        'nationality',
        'national_id_card',
        'candidate_status_id',
        'move_anywhere',
        'experience',
        'career_level_id',
        'industry_id',
        'functional_area_id',
        'current_salary',
        'expected_salary',
        'expected_salary_to',
        'salary_currency',
        'address',
        'immediate_available',
        'available_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                 => 'integer',
        'user_id'            => 'integer',
        'current_salary'     => 'double',
        'expected_salary'    => 'integer',
        'expected_salary_to'    => 'integer',
        'career_level_id'    => 'integer',
        'industry_id'        => 'integer',
        'functional_area_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name'        => 'required|max:180',
        'last_name'         => 'required|max:180',
        'password'      => 'required|same:password_confirmation|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'able_to_travel_distance' => 'integer|min:10|max:150',
        'expected_salary' => 'required_with:expected_salary_to|integer|gte:0',
        'expected_salary_to' => 'required_with:expected_salary|integer|gte:expected_salary',
        'candidate_status_id'=>'required|integer',
        'email'             => 'required|email:filter|unique:users,email',
        'gender'            => 'required',
        'dob'               => 'required|date',
        'phone'             => 'required',
        'zipCode'           => 'required|numeric|exists:postal_codes,postal_code',
        'city'              => 'required|exists:cities,name',
    ];

    protected $appends = ['country_name', 'state_name', 'city_name', 'full_location', 'candidate_url'];
    protected $with = ['user','city','candidateJobCategories'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return string
     */
    public function getFullLocationAttribute()
    {
        $location = '';
        if (! empty($this->user->country)) {
            $location = $this->user->country->name;
        }
        if (! empty($this->user->state)) {
            $location = $location.','.$this->user->state->name;
        }
        if (! empty($this->user->city)) {
            $location = $location.','.$this->user->city->name;
        }
        return (!empty($location)) ? $location : null;
    }



    public function getCandidateCVCount(){

        return count((new MediaFactory())->getCVs($this));

    }
    /**
     * @return mixed
     */
    public function getCandidateUrlAttribute()
    {
        /** @var Media $media */
        if($this->user) {
            $media = $this->user->getMedia(User::PROFILE)->first();
            if (!empty($media)) {
                return $media->getFullUrl();
            }
        }

        return asset('assets/img/employer-image.png');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function jobApplication()
    {
        return $this->hasMany(JobApplication::class, 'candidate_id');
    }

    /**
     * @return BelongsTo
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    /**
     * @return BelongsTo
     */
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function careerLevel()
    {
        return $this->belongsTo(CareerLevel::class, 'career_level_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateJobCategories()
    {
        return $this->belongsToMany(JobCategory::class, 'candidate_job_category', 'candidate_id', 'job_category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateJobShift()
    {
        return $this->belongsToMany(JobShift::class, 'candidate_job_shift', 'candidate_id', 'job_shift_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateJobType()
    {
        return $this->belongsToMany(JobType::class, 'candidate_job_type', 'candidate_id', 'job_type_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateAbleToTravelCity()
    {
        return $this->belongsToMany(City::class, 'candidate_able_to_travel_town', 'candidate_id', 'city_id');
    }


    /**
     * @return BelongsToMany
     */
    public function candidateAbleToMoveCity()
    {
        return $this->belongsToMany(City::class, 'candidate_able_to_move_town', 'candidate_id', 'city_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateExtraRequirements(){
        return $this->belongsToMany(ExtraRequirements::class, 'candidate_extra_requirements', 'candidate_id', 'requirement_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateCircumstances(){
        return $this->belongsToMany(Circumstances::class, 'candidate_circumstances', 'candidate_id', 'circumstances_id');
    }

    /**
     * @return BelongsToMany
     */
    public function candidateDrivingLicence(){
        return $this->belongsToMany(DrivingLicences::class, 'candidate_driving_licences', 'candidate_id', 'driving_licence_id');
    }

    /**
     * @return BelongsTo
     */
    public function functionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    /**
     * @return BelongsToMany
     */
    public function jobAlerts()
    {
        return $this->belongsToMany(JobType::class, 'jobs_alerts', 'candidate_id', 'job_type_id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penddingJobApplications()
    {
        return $this->hasMany(JobApplication::class, 'candidate_id')->where('status', JobApplication::STATUS_APPLIED);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
