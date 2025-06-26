<?php

namespace App\Models;

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
 * @property string $advantages
 * @property string $tasks
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
class JobSearchResult extends Job
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public $distance;
    protected $appends = [
        'company','distance'
    ];

    public function getDistance(){
        return $this->distance;
    }

}
