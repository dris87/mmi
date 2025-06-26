<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MethodPermission
 */
class MethodPermission extends Model
{
    public $table = 'method_permissions';

    protected $fillable = [
        'permission_id',
        'controller_name',
        'method_name',
        'enabled',
        'created_at',
        'updated_at',
    ];
}
