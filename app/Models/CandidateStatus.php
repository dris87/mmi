<?php

namespace App\Models;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property \App\Models\Candidate[] $candidates
 */
class CandidateStatus extends Model
{
    const STATUS_AKTIV = 1;
    const STATUS_INAKTIV = 2;
    const STATUS_ELHELYEZKEDETT = 3;
    const STATUS_NEM_KERES_MUNKAT = 4;
    const STATUS_JAVITASRA_VAR = 5;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate_status';

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
    public function candidates()
    {
        return $this->hasMany('App\Candidate');
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


}
