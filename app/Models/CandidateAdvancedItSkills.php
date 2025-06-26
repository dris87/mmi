<?php

namespace App\Models;

use App\Models\AdvancedItSkills;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * @property integer $id
 * @property string $skill
 * @property integer $skill_level_id
 * @property int $candidate_id
 * @property string $created_at
 * @property string $updated_at
 * @property Candidate $candidate
 * @property SkillLevel $skillLevel
 */
class CandidateAdvancedItSkills extends Model
{
    use LogsActivity;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['skill', 'skill_level_id', 'candidate_id', 'created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'skill', 'skill_level.name'];

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
    public function skillLevel()
    {
        return $this->belongsTo('App\Models\SkillLevel');
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
    public function getSkillLevelId()
    {
        return $this->skill_level_id;
    }

    /**
     * @param int $skill_level_id
     */
    public function setSkillLevelId(int $skill_level_id)
    {
        $this->skill_level_id = $skill_level_id;
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
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param string $skill
     */
    public function setSkill(string $skill)
    {
        $this->skill = $skill;
    }

}
