<?php

namespace App\Models;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $user_id
 * @property int $language_id
 * @property integer $language_level_id
 * @property string $created_at
 * @property string $updated_at
 * @property Language $language
 * @property LanguageLevel $languageLevel
 * @property User $user
 */
class CandidateLanguage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate_language';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'language_id', 'language_level_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function languageLevel()
    {
        return $this->belongsTo('App\Models\LanguageLevel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * @param int $language_id
     */
    public function setLanguageId(int $language_id)
    {
        $this->language_id = $language_id;
    }

    /**
     * @return int
     */
    public function getLanguageLevelId()
    {
        return $this->language_level_id;
    }

    /**
     * @param int $language_level_id
     */
    public function setLanguageLevelId(int $language_level_id)
    {
        $this->language_level_id = $language_level_id;
    }




}
