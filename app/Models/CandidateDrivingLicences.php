<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\DrivingLicences;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $driving_licence_id
 * @property int $candidate_id
 * @property string $created_at
 * @property string $updated_at
 * @property Candidate $candidate
 * @property DrivingLicences $drivingLicence
 */
class CandidateDrivingLicences extends Model
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
    protected $fillable = ['driving_licence_id', 'candidate_id', 'created_at', 'updated_at'];

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
    public function drivingLicence()
    {
        return $this->belongsTo('App\DrivingLicence');
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
    public function getDrivingLicenceId(): int
    {
        return $this->driving_licence_id;
    }

    /**
     * @param int $driving_licence_id
     */
    public function setDrivingLicenceId(int $driving_licence_id): void
    {
        $this->driving_licence_id = $driving_licence_id;
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
