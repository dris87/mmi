<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficeUserExtraPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'backoffice_user_id',
        'permission_id',
        'created_at',
        'updated_at',
    ];

    public function getPermissionId()
    {
        return $this->permission_id;
    }
}
