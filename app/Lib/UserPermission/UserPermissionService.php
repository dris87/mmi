<?php

namespace App\Lib\UserPermission;

use App\Models\MethodPermission;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserPermissionService
{
    const CACHE_SUFFIX = 'PermissionMiddleware';

    const ERROR_MESSAGE_USER_HAS_NO_PERMISSION = 'user has no permission for this action!';

    private $user;

    private $cache;

    private $cacheTTL;

    private $active;

    private $isAdmin = false;

    private $savePermissionMode;

    private $savePermissionModeIdList;

    private $adminPermissionName;

    private $permissionRepository;

    private $methodPermissionService;

    private $userPermissions;

    public function __construct(
        User $user,
        PermissionRepository $permissionRepository,
        MethodPermissionService $methodPermissionService,
        array $config = []
    )
    {
        $this->configure($config);
        $this->user = $user;
        $this->permissionRepository = $permissionRepository;
        $this->methodPermissionService = $methodPermissionService;
        $this->isAdmin = $this->userIsAdmin();
        $this->userPermissions = $this->getUserPermissions();
    }

    public function configure(array $config)
    {
        $this->cache                = $config['cache'];
        $this->cacheTTL             = $config['cache_ttl'];
        $this->active               = $config['active'];
        $this->adminPermissionName  = $config['admin_permission_name'];
        $this->savePermissionMode   = $config['save_permission_mode'];
        $this->savePermissionModeIdList  = $config['save_permission_mode_id_list'];
    }

    public function userHasPermission(
        string $controller,
        string $controllerMethod
    ): bool
    {
        return $this->isAdmin ||
            isset($this->userPermissions[$controller . '.' . $controllerMethod]);
    }

    public function getUserPermissions()
    {
        if ($this->cache && $userPermissions = Cache::get('BACKOFFICE_PERMISSIONS_' . $this->user->getId())) {
            return $userPermissions;
        }

        $userPermissions = $this->methodPermissionService->getAllowedMethods($this->user);

        if ($this->cache) {
            Cache::add('BACKOFFICE_PERMISSIONS_' . $this->user->getId(), $userPermissions, $this->cacheTTL);
        }

        return $userPermissions;
    }

    /**
     * @throws \Exception
     */
    public function handlePermission(
        string $controller,
        string $controllerMethod
    ): bool
    {
        if (!$this->userHasPermission($controller, $controllerMethod)) {
            if ($this->savePermissionMode) {
                foreach ($this->savePermissionModeIdList as $permissionId) {
                    MethodPermission::firstOrCreate([
                        'permission_id'     => $permissionId,
                        'controller_name'   => $controller,
                        'method_name'       => $controllerMethod,
                        'enabled'           => true,
                    ]);
                }
                return true;
            }
            throw new \Exception(self::ERROR_MESSAGE_USER_HAS_NO_PERMISSION);
        }
        return true;
    }

    public function userIsAdmin(): bool
    {
        if ($this->cache && $userIsAdmin = Cache::get('BACKOFFICE_ADMIN_PERMISSION_' . $this->user->getId())) {
            return $userIsAdmin;
        }

        $mainPermission = $this->permissionRepository->findByUserId($this->user->getId());
        $userIsAdmin = $mainPermission->name === $this->adminPermissionName;

        if ($this->cache) {
            Cache::add('BACKOFFICE_ADMIN_PERMISSION_' . $this->user->getId(), $userIsAdmin, $this->cacheTTL);
        }

        return $userIsAdmin;
    }

    public function isActive()
    {
        return $this->active;
    }

    private function getCacheKey($controller, $controllerMethod): string
    {
        return self::CACHE_SUFFIX . '_' .
            $controller . '_' .
            $controllerMethod . '_' .
            $this->user->getId();
    }
}
