<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Activitylog\Traits\LogsActivity;
/**
 * App\Models\CompanyUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property int $permission_id
 * @property int $coworker_position_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property bool $is_active
 * @property int $company_site_id
 * @property int $created_by
 * @property string $created_at
 * @property string $last_login
 **/
class CompanyUser extends Model
{
    use LogsActivity;
    use HasFactory;

    /**
     * @var string[]
     */
    public $timestamps = ["created_at"];
    /**
     *
     */
    const UPDATED_AT = null;

    /**
     * @var string[]
     */
    public $fillable = [
        'user_id',
        'company_id',
        'role_id',
        'created_by',
    ];

    /**
     * @var string
     */
    protected static $logName = 'Users/CompanyUser';
    /**
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * @var string[]
     */
    protected static $logAttributes = [
        'user_id',
        'company_id',
        'role_id',
        'created_by',
    ];

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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId(int $company_id): void
    {
        $this->company_id = $company_id;
    }


    /**
     * @return int
     */
    public function getCreatedBy(): int
    {
        return $this->created_by;
    }

    /**
     * @param int $created_by
     */
    public function setCreatedBy(int $created_by): void
    {
        $this->created_by = $created_by;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @return MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'owner');
    }

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permission_id;
    }

    /**
     * @param int $permission_id
     */
    public function setPermissionId(int $permission_id): void
    {
        $this->permission_id = $permission_id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return int|null
     */
    public function getCompanySiteId(): ?int
    {
        return $this->company_site_id;
    }

    /**
     * @param int|null $company_site_id
     */
    public function setCompanySiteId(?int $company_site_id): void
    {
        $this->company_site_id = $company_site_id;
    }

    /**
     * @return string|null
     */
    public function getLastLogin(): ?string
    {
        return $this->last_login;
    }

    /**
     * @param string|null $last_login
     */
    public function setLastLogin(?string $last_login): void
    {
        $this->last_login = $last_login;
    }

    /**
     * @return int|null
     */
    public function getCoworkerPositionId(): ?int
    {
        return $this->coworker_position_id;
    }

    /**
     * @param int|null $coworker_position_id
     */
    public function setCoworkerPositionId(?int $coworker_position_id): void
    {
        $this->coworker_position_id = $coworker_position_id;
    }



}
