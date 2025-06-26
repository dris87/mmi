<?php

namespace App\Lib\Backoffice\User;

use App\Models\BackofficeUser;

class BackofficeUserForm
{
    public function getFormData(
        BackofficeUser $backOfficeUserModel = null
    ): array
    {
        return [
            'id' => 'backofficeUserForm',
            'action' => 'backofficeuser.store',
            'back' => 'backoffice.user.index',
            'sections' => [
                [
                    'title' => 'messages.backoffice.user.form_section_default_data',
                    'fields' => [
                        [
                            'id' => 'backofficeUserFormFirstName',
                            'name' => 'first_name',
                            'title' => 'messages.backoffice.user.first_name',
                            'type' => 'text',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getFirstName()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormLastName',
                            'name' => 'last_name',
                            'title' => 'messages.backoffice.user.last_name',
                            'type' => 'text',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getLastName()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormDob',
                            'name' => 'dob',
                            'title' => 'messages.backoffice.user.birth_date',
                            'type' => 'date_picker',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getDateOfBirth()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormNotifiedName',
                            'name' => 'notified_name',
                            'title' => 'messages.backoffice.user.notified_name',
                            'required' => true,
                            'type' => 'text',
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getNotifiedName()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormNotifiedPhone',
                            'name' => 'notified_phone',
                            'title' => 'messages.backoffice.user.notified_phone',
                            'type' => 'number',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getNotifiedPhone()
                                : '',
                        ],
                    ]
                ],
                [
                    'title' => 'messages.backoffice.user.form_section_professional',
                    'fields' => [
                        [
                            'id' => 'backofficeUserFormEmail',
                            'name' => 'email',
                            'title' => 'messages.backoffice.user.email',
                            'type' => 'email',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getEmail()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormPhone',
                            'name' => 'phone',
                            'title' => 'messages.backoffice.user.phone',
                            'type' => 'number',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->getPhone()
                                : '',
                        ],
                        [
                            'id' => 'backofficeUserFormPositionId',
                            'name' => 'position_id',
                            'title' => 'messages.backoffice.user.position',
                            'type' => 'select2_ajax',
                            'ajaxUrl' => 'select2.backofficePositions',
                            'required' => true,
                            'value' => $backOfficeUserModel
                            ? [
                                'id' => $backOfficeUserModel->getPositionId(),
                                'text' => $backOfficeUserModel->position->name ?? ''
                            ]
                            : [],
                        ],
                        [
                            'id' => 'backofficeUserFormBranchOfficeId',
                            'name' => 'branch_office_id',
                            'title' => 'messages.backoffice.user.branch_office',
                            'type' => 'select2_ajax',
                            'ajaxUrl' => 'select2.backofficeBranchOffices',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? [
                                    'id' => $backOfficeUserModel->getBranchOfficeId(),
                                    'text' => $backOfficeUserModel->branchOffice->name ?? ''
                                ]
                                : [],
                        ],
                        [
                            'id' => 'backofficeUserFormSuperiorId',
                            'name' => 'superior_id',
                            'title' => 'messages.backoffice.user.superior',
                            'type' => 'select2_ajax',
                            'required' => true,
                            'ajaxUrl' => 'select2.backofficeSuperiors',
                            'excluded' => $backOfficeUserModel ? $backOfficeUserModel->getId() : null,
                            'value' => $backOfficeUserModel
                                ? [
                                    'id' => $backOfficeUserModel->getSuperiorId(),
                                    'text' => $backOfficeUserModel->superior->first_name.' '.$backOfficeUserModel->superior->last_name ?? ''
                                ]
                                : [],
                        ],
                    ]
                ],
                [
                    'title' => 'messages.backoffice.user.form_section_permission',
                    'fields' => [
                        [
                            'id' => 'backofficeUserFormMainPermissionId',
                            'name' => 'main_permission_id',
                            'title' => 'messages.backoffice.user.main_permission',
                            'type' => 'select2_ajax',
                            'ajaxUrl' => 'select2.permissions',
                            'required' => true,
                            'value' => $backOfficeUserModel
                                ? [
                                    'id' => $backOfficeUserModel->getMainPermissionid(),
                                    'text' => $backOfficeUserModel->mainPermission->name ?? ''
                                ]
                                : [],
                        ],
                        [
                            'id' => 'backofficeUserFormExtraPermissionIds',
                            'name' => 'extra_permission_ids[]',
                            'title' => 'messages.backoffice.user.extra_permissions',
                            'type' => 'select2_ajax',
                            'multiple' => true,
                            'ajaxUrl' => 'select2.permissions',
                            'value' => $backOfficeUserModel
                                ? $backOfficeUserModel->extraPermissions->map(function($item) {
                                    return [
                                        'id' => $item->id,
                                        'text' => $item->name
                                    ];
                                })->all()
                                : [],
                        ],
                    ]
                ]
            ]
        ];
    }
}
