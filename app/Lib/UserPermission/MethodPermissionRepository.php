<?php

namespace App\Lib\UserPermission;

use App\Models\MethodPermission;

class MethodPermissionRepository
{
	public function findUserMethodPermission(
        int $userId,
        string $controllerName,
        string $controllerMethod
    ) {
		return $this->findUserAllowedMethods($userId)
			->where('method_name', $controllerMethod)
			->where('controller_name', $controllerName)
            ->where('enabled', true)
            ->first();
	}

    public function findUserMethodPermissions(int $userId)
    {
        return \DB::table('method_permissions')
            ->select(
                'method_permissions.controller_name',
                'method_permissions.method_name',
                \DB::raw("CONCAT(method_permissions.controller_name, '.', method_permissions.method_name) as permission")
            )
            ->leftJoin('backoffice_users', function($join) use ($userId) {
                $join->on('method_permissions.permission_id', 'main_permission_id')
                    ->where('backoffice_users.user_id', $userId);
            })
            ->leftJoin('backoffice_user_extra_permissions', function($join) {
                $join->on('method_permissions.permission_id', 'backoffice_user_extra_permissions.permission_id')
                    ->where('backoffice_user_id', \DB::raw('backoffice_users.id'));
            })
            ->where('enabled', true)
            ->get();
    }

	public function findUserAllowedMethods(int $userId)
	{
		return MethodPermission::select('method_permissions.*')
			->leftJoin('backoffice_users', function($join) use ($userId) {
				$join->on('method_permissions.permission_id', 'main_permission_id')
					->where('backoffice_users.user_id', $userId);
			})
			->leftJoin('backoffice_user_extra_permissions', function($join) {
				$join->on('method_permissions.permission_id', 'backoffice_user_extra_permissions.permission_id')
					->where('backoffice_user_id', \DB::raw('backoffice_users.id'));
			});
	}
}
