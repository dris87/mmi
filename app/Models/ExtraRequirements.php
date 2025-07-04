<?php

namespace App\Models;

use App\Models\CandidateExtraRequirements;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property CandidateExtraRequirements[] $candidateExtraRequirements
 */
class ExtraRequirements extends Model
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
    protected $fillable = ['name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidateExtraRequirements()
    {
        return $this->hasMany('App\CandidateExtraRequirement', 'requirement_id');
    }


}
