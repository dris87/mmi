<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\City;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $candidate_id
 * @property integer $city_id
 * @property string $created_at
 * @property string $updated_at
 * @property \App\Models\Candidate $candidate
 * @property \App\Models\City $city
 */
class CandidateAbleToMoveTown extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate_able_to_move_town';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['candidate_id', 'city_id', 'created_at', 'updated_at'];

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
    public function city()
    {
        return $this->belongsTo('App\City');
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
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param int $city_id
     */
    public function setCityId(int $city_id)
    {
        $this->city_id = $city_id;
    }


}
