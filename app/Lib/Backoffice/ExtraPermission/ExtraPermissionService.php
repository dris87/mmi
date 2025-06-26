<?php

namespace App\Lib\Backoffice\ExtraPermission;

use App\Models\BackofficeUser;

class ExtraPermissionService
{
    private $extraPermissionRepository;

    public function __construct(
        ExtraPermissionRepository $extraPermissionRepository
    ) {
        $this->extraPermissionRepository = $extraPermissionRepository;
    }

    public function updateExtraPermissions(BackofficeUser $backofficeUserModel, array $permissions)
    {
        $extraPermissions = $this->extraPermissionRepository
            ->getExtraPermissions($backofficeUserModel->getId());

        $this->extraPermissionRepository->updateExtraPermissions(
            $backofficeUserModel,
            $extraPermissions,
            $permissions
        );
    }

    public function getRepository(): ExtraPermissionRepository
    {
        return $this->extraPermissionRepository;
    }

}
