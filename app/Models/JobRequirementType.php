<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $id
 * @property string $name
 * @property string $translation_key
 * @property string $view_key
 * @property string $created_at
 * @property string $updated_at
 */
class JobRequirementType extends Model
{
    use HasFactory;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return $this->translation_key;
    }

    /**
     * @param string $translation_key
     */
    public function setTranslationKey(string $translation_key): void
    {
        $this->translation_key = $translation_key;
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

    /**
     * @return string
     */
    public function getViewKey(): string
    {
        return $this->view_key;
    }

    /**
     * @param string $view_key
     */
    public function setViewKey(string $view_key): void
    {
        $this->view_key = $view_key;
    }

}
