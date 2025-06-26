<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\ExtraRequirements;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $candidate_id
 * @property integer $requirement_id
 * @property string $created_at
 * @property string $updated_at
 * @property Candidate $candidate
 * @property ExtraRequirements $extraRequirement
 */
class CandidateExtraRequirements extends Model
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
    protected $fillable = ['candidate_id', 'requirement_id', 'created_at', 'updated_at'];

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
    public function extraRequirement()
    {
        return $this->belongsTo('App\ExtraRequirement', 'requirement_id');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCandidateId()
    {
        return $this->candidate_id;
    }

    /**
     * @param int $candidate_id
     */
    public function setCandidateId(int $candidate_id)
    {
        $this->candidate_id = $candidate_id;
    }

    /**
     * @return int
     */
    public function getRequirementId()
    {
        return $this->requirement_id;
    }

    /**
     * @param int $requirement_id
     */
    public function setRequirementId(int $requirement_id)
    {
        $this->requirement_id = $requirement_id;
    }


}
