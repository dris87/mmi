<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $log_name
 * @property string $description
 * @property string $subject_type
 * @property integer $subject_id
 * @property string $causer_type
 * @property integer $causer_id
 * @property mixed $properties
 * @property string $created_at
 * @property string $updated_at
 */
class ActivityLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['log_name', 'description', 'subject_type', 'subject_id', 'causer_type', 'causer_id', 'properties', 'created_at', 'updated_at'];

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
     * @return string
     */
    public function getLogName()
    {
        return $this->log_name;
    }

    /**
     * @param string $log_name
     */
    public function setLogName(string $log_name)
    {
        $this->log_name = $log_name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSubjectType()
    {
        return $this->subject_type;
    }

    /**
     * @param string $subject_type
     */
    public function setSubjectType(string $subject_type)
    {
        $this->subject_type = $subject_type;
    }

    /**
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * @param int $subject_id
     */
    public function setSubjectId(int $subject_id)
    {
        $this->subject_id = $subject_id;
    }

    /**
     * @return string
     */
    public function getCauserType()
    {
        return $this->causer_type;
    }

    /**
     * @param string $causer_type
     */
    public function setCauserType(string $causer_type)
    {
        $this->causer_type = $causer_type;
    }

    /**
     * @return int
     */
    public function getCauserId()
    {
        return $this->causer_id;
    }

    /**
     * @param int $causer_id
     */
    public function setCauserId(int $causer_id)
    {
        $this->causer_id = $causer_id;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }


}
