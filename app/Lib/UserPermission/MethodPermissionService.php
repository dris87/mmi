<?php

namespace App\Lib\UserPermission;

use App\Models\User;

class MethodPermissionService
{
	private $methodPermissionRepository;

	public function __construct(
		MethodPermissionRepository $methodPermissionRepository
	) {
		$this->methodPermissionRepository = $methodPermissionRepository;
	}

	public function actionIsAllowed(User $user, string $controller, string $controllerMethod)
	{
		$methodPermissionModel = $this->methodPermissionRepository
			->findUserMethodPermission($user->getId(), $controller, $controllerMethod);

		return (bool)$methodPermissionModel;
	}

	public function getAllowedMethods(User $user)
	{
		return $this->methodPermissionRepository
            ->findUserMethodPermissions($user->getId())
            ->keyBy('permission')->all();
	}
}
