<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackofficeUser extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'user_id' => 'required',
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email|unique:backoffice_users',
        'dob' => 'required',
        'phone' => 'required',
        'notified_name' => 'required|min:3',
        'notified_phone' => 'required',
        'superior_id' => 'required',
        'branch_office_id' => 'required',
        'position_id' => 'required',
        'main_permission_id' => 'required',
    ];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'notified_name',
        'notified_phone',
        'superior_id',
        'position_id',
        'branch_office_id',
        'main_permission_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function superior(): BelongsTo
    {
        return $this->belongsTo(BackofficeUser::class, 'superior_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(BackofficePosition::class, 'position_id');
    }

    public function branchOffice(): BelongsTo
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }

    public function mainPermission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'main_permission_id');
    }

    public function extraPermissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'backoffice_user_extra_permissions',
            'backoffice_user_id',
            'permission_id',
            'id',
            'id'
        );
    }

    public function isAdmin()
    {
        return $this->mainPermission && $this->mainPermission->is_admin;
    }

    public function getName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getDateOfBirth()
    {
        return $this->dob;
    }

    public function getNotifiedName()
    {
        return $this->notified_name;
    }

    public function getNotifiedPhone()
    {
        return $this->notified_phone;
    }

    public function getSuperiorId()
    {
        return $this->superior_id;
    }

    public function getPositionId()
    {
        return $this->position_id;
    }

    public function getBranchOfficeId()
    {
        return $this->branch_office_id;
    }

    public function getMainPermissionid()
    {
        return $this->main_permission_id;
    }
}
