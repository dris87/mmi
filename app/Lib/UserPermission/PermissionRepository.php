<?php

namespace App\Lib\UserPermission;

use App\Models\Permission;

class PermissionRepository
{
	public function findByUserId(int $userId)
	{
		return Permission::select('permissions.*')
			->join('backoffice_users', 'permissions.id', 'main_permission_id')
			->where('backoffice_users.user_id', $userId)
			->first();
	}
}