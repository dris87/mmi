<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $phone
 * @property bool $is_frontoffice
 * @property bool $is_admin
 * @property string $created_at
 * @property string $updated_at
 **/
class Permission extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'name',
        'is_frontoffice',
        'guard_name',
        'is_admin'
    ];

    protected $table = 'permissions';

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
    public function getGuardName(): string
    {
        return $this->guard_name;
    }

    /**
     * @param string $guard_name
     */
    public function setGuardName(string $guard_name): void
    {
        $this->guard_name = $guard_name;
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
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return bool
     */
    public function isIsFrontoffice(): bool
    {
        return $this->is_frontoffice;
    }

    /**
     * @param bool $is_frontoffice
     */
    public function setIsFrontoffice(bool $is_frontoffice): void
    {
        $this->is_frontoffice = $is_frontoffice;
    }

    /**
     * @return bool
     */
    public function isIsAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }
}
