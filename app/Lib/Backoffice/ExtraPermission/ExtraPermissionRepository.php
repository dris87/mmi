<?php

namespace App\Lib\Backoffice\ExtraPermission;

use App\Models\BackofficeUser;
use App\Models\BackofficeUserExtraPermission;
use App\Models\Factories\Exceptions\FactoryDeleteException;
use App\Models\Factories\Exceptions\FactoryException;

class ExtraPermissionRepository
{
    public function addExtraPermission(
        int $backOfficeUserId,
        int $permissionId
    ) {
        return BackofficeUserExtraPermission::create([
            'backoffice_user_id' => $backOfficeUserId,
            'permission_id' => $permissionId
        ]);
    }

    /**
     * @throws FactoryException
     */
    public function addExtraPermissions(
        BackofficeUser $backofficeUserModel,
        array          $permissionIds
    ): bool
    {
        foreach ($permissionIds as $permissionId) {
            $backofficeUserExtraPermissionModel = $this->addExtraPermission(
                $backofficeUserModel->getId(),
                $permissionId
            );

            if (!$backofficeUserExtraPermissionModel) {
                throw new FactoryException();
            }
        }

        return true;
    }

    public function getExtraPermissions(int $backofficeUserId)
    {
        return BackofficeUserExtraPermission::where('backoffice_user_id', $backofficeUserId)->get();
    }

    /**
     * @throws FactoryException
     * @throws FactoryDeleteException
     */
    public function updateExtraPermissions(
        BackofficeUser $backofficeUserModel,
        $existingExtraPermissions,
        array $permissionIds
    ): bool
    {
        foreach ($existingExtraPermissions as $existingExtraPermission) {
            if (!$key = array_search((string)$existingExtraPermission->getPermissionId(), $permissionIds)) {
                if (!$existingExtraPermission->delete()) {
                    throw new FactoryDeleteException($existingExtraPermission);
                }
            } else {
                unset($permissionIds[$key]);
            }
        }

        if (!empty($permissionIds)) {
            $this->addExtraPermissions($backofficeUserModel, $permissionIds);
        }

        return true;
    }
}
