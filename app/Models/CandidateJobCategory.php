<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $job_category_id
 * @property int $candidate_id
 * @property string $created_at
 * @property string $updated_at
 * @property \App\Models\Candidate $candidate
 * @property \App\Models\JobCategory $jobCategory
 */
class CandidateJobCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate_job_category';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['job_category_id', 'candidate_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobCategory()
    {
        return $this->belongsTo('App\JobCategory');
    }


}
