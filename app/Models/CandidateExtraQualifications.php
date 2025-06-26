<?php

namespace App\Models;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $candidate_id
 * @property string $driving_licence
 * @property string $bacis_it_skills
 * @property string $advanced_it_skills
 * @property string $hobbies
 * @property string $other_comments
 * @property string $created_at
 * @property string $updated_at
 * @property Candidate $candidate
 */
class CandidateExtraQualifications extends Model
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
    protected $fillable = ['candidate_id', 'driving_licence', 'bacis_it_skills', 'advanced_it_skills', 'hobbies', 'other_comments', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
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
    public function setId(int $id)
    {
        $this->id = $id;
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
    public function setCandidateId(int $candidate_id)
    {
        $this->candidate_id = $candidate_id;
    }

    /**
     * @return string
     */
    public function getDrivingLicence()
    {
        return $this->driving_licence;
    }

    /**
     * @param string $driving_licence
     */
    public function setDrivingLicence(?string $driving_licence)
    {
        $this->driving_licence = $driving_licence;
    }

    /**
     * @return string
     */
    public function getBacisItSkills()
    {
        return $this->bacis_it_skills;
    }

    /**
     * @param string $bacis_it_skills
     */
    public function setBacisItSkills(?string $bacis_it_skills)
    {
        $this->bacis_it_skills = $bacis_it_skills;
    }

    /**
     * @return string
     */
    public function getAdvancedItSkills()
    {
        return $this->advanced_it_skills;
    }

    /**
     * @param string $advanced_it_skills
     */
    public function setAdvancedItSkills(?string $advanced_it_skills)
    {
        $this->advanced_it_skills = $advanced_it_skills;
    }

    /**
     * @return string
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }

    /**
     * @param string $hobbies
     */
    public function setHobbies(?string $hobbies)
    {
        $this->hobbies = $hobbies;
    }

    /**
     * @return string
     */
    public function getOtherComments()
    {
        return $this->other_comments;
    }

    /**
     * @param string $other_comments
     */
    public function setOtherComments(?string $other_comments)
    {
        $this->other_comments = $other_comments;
    }


}
