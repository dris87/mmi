<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $job_shift_id
 * @property int $candidate_id
 * @property string $created_at
 * @property string $updated_at
 * @property \App\Models\Candidate $candidate
 * @property \App\Models\JobShift $jobShift
 */
class CandidateJobShift extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate_job_shift';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['job_shift_id', 'candidate_id', 'created_at', 'updated_at'];

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
    public function jobShift()
    {
        return $this->belongsTo('App\JobShift');
    }
}
