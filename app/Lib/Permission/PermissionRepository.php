<?php

namespace App\Lib\Permission;

use App\Models\Permission;

class PermissionRepository
{
    public function all()
    {
        return Permission::all();
    }
}
