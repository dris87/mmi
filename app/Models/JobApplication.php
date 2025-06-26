<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\JobApplication
 *
 * @property int $id
 * @property int $job_id
 * @property int $candidate_id
 * @property int $resume_id
 * @property float $expected_salary
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|JobApplication newModelQuery()
 * @method static Builder|JobApplication newQuery()
 * @method static Builder|JobApplication query()
 * @method static Builder|JobApplication whereCandidateId($value)
 * @method static Builder|JobApplication whereCreatedAt($value)
 * @method static Builder|JobApplication whereExpectedSalary($value)
 * @method static Builder|JobApplication whereId($value)
 * @method static Builder|JobApplication whereJobId($value)
 * @method static Builder|JobApplication whereNotes($value)
 * @method static Builder|JobApplication whereResumeId($value)
 * @method static Builder|JobApplication whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Candidate $candidate
 * @property-read \App\Models\Job $job
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobApplication whereStatus($value)
 * @property-read mixed $resume_url
 * @property int|null $job_stage_id
 * @property-read JobStage|null $jobStage
 * @method static Builder|JobApplication whereJobStageId($value)
 */
class JobApplication extends Model
{
    public $table = 'job_applications';

  //  protected $appends = ['resume_url'];

    const STATUS_DRAFT = 0;
    const STATUS_APPLIED = 1;
    const REJECTED = 2;
    const COMPLETE = 3;
    const SHORT_LIST = 4;

    const STATUS = [
        0 => 'Drafted',
        1 => 'Applied',
        2 => 'Declined',
        3 => 'Hired',
        4 => 'Ongoing',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'primary',
        2 => 'danger',
        3 => 'info',
        4 => 'success',
    ];

    public $fillable = [
        'job_id',
        'candidate_id',
        'resume_id',
        'expected_salary',
        'notes',
        'status',
        'job_stage_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'job_id'          => 'integer',
        'candidate_id'    => 'integer',
        'resume_id'       => 'integer',
        'status'          => 'integer',
        'expected_salary' => 'double',
        'notes'           => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'job_id' => 'required',
        'resumes' => 'required|exists:media,id',
    ];

    protected $with = ['candidate'];

    /**
     * @return BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }


    /**
     * @return BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * @return BelongsTo
     */
    public function jobStage()
    {
        return $this->belongsTo(JobStage::class, 'job_stage_id');
    }

    /**
     * @return mixed
     */
    public function getResumeUrlAttribute()
    {
        /** @var Media $media */
        $media = Media::find($this->resume_id);
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return null;
    }

    /**
     * @return HasMany
     */
    public function applicationSchedule(): HasMany
    {
        return $this->hasMany(JobApplicationSchedule::class, 'job_application_id');
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
     * @return int
     */
    public function getCandidateId(): int
    {
        return $this->candidate_id;
    }

    /**
     * @param int $candidate_id
     */
    public function setCandidateId(int $candidate_id): void
    {
        $this->candidate_id = $candidate_id;
    }

    /**
     * @return int
     */
    public function getResumeId(): int
    {
        return $this->resume_id;
    }

    /**
     * @param int $resume_id
     */
    public function setResumeId(int $resume_id): void
    {
        $this->resume_id = $resume_id;
    }

    /**
     * @return float
     */
    public function getExpectedSalary(): float
    {
        return $this->expected_salary;
    }

    /**
     * @param float $expected_salary
     */
    public function setExpectedSalary(float $expected_salary): void
    {
        $this->expected_salary = $expected_salary;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
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

    /**
     * @return Candidate
     */
    public function getCandidate(): Candidate
    {
        return $this->candidate;
    }

    /**
     * @param Candidate $candidate
     */
    public function setCandidate(Candidate $candidate): void
    {
        $this->candidate = $candidate;
    }

    /**
     * @return Job
     */
    public function getJob(): Job
    {
        return $this->job;
    }

    /**
     * @param Job $job
     */
    public function setJob(Job $job): void
    {
        $this->job = $job;
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
     * @return mixed
     */
    public function getResumeUrl(): mixed
    {
        return $this->resume_url;
    }

    /**
     * @param mixed $resume_url
     */
    public function setResumeUrl(mixed $resume_url): void
    {
        $this->resume_url = $resume_url;
    }

    /**
     * @return int|null
     */
    public function getJobStageId(): ?int
    {
        return $this->job_stage_id;
    }

    /**
     * @param int|null $job_stage_id
     */
    public function setJobStageId(?int $job_stage_id): void
    {
        $this->job_stage_id = $job_stage_id;
    }

    /**
     * @return JobStage|null
     */
    public function getJobStage(): ?JobStage
    {
        return $this->jobStage;
    }

    /**
     * @param JobStage|null $jobStage
     */
    public function setJobStage(?JobStage $jobStage): void
    {
        $this->jobStage = $jobStage;
    }


}
