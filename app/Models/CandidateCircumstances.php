<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\Circumstances;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $circumstances_id
 * @property int $candidate_id
 * @property string $created_at
 * @property string $updated_at
 * @property \App\Models\Candidate $candidate
 * @property Circumstances $circumstance
 */
class CandidateCircumstances extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['circumstances_id', 'candidate_id', 'created_at', 'updated_at'];

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
    public function circumstance()
    {
        return $this->belongsTo('App\Circumstance', 'circumstances_id');
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
    public function getCircumstancesId(): int
    {
        return $this->circumstances_id;
    }

    /**
     * @param int $circumstances_id
     */
    public function setCircumstancesId(int $circumstances_id): void
    {
        $this->circumstances_id = $circumstances_id;
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

}
