<?php

namespace App\Lib\Backoffice\User;

use App\Helpers\Mailer;
use App\Lib\Backoffice\BranchOffice\BranchOfficeRepository;
use App\Lib\Backoffice\ExtraPermission\ExtraPermissionService;
use App\Lib\PasswordReset\PasswordResetService;
use App\Lib\Position\PositionRepository;
use App\Lib\Permission\PermissionRepository;
use App\Lib\User\UserRepository;
use App\Models\BackofficeUser;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class BackofficeUserService
{
    private $userRepository;
    private $backofficeUserForm;
    private $positionRepository;
    private $permissionRepository;
    private $branchOfficeRepository;
    private $backofficeUserRepository;
    private $extraPermissionService;
    /**
     * @var PasswordResetService
     */
    private $passwordResetService;
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(
        Mailer                   $mailer,
        BackofficeUserForm       $backofficeUserForm,
        UserRepository           $userRepository,
        PositionRepository       $positionRepository,
        PermissionRepository     $permissionRepository,
        ExtraPermissionService   $extraPermissionService,
        BranchOfficeRepository   $branchOfficeRepository,
        BackofficeUserRepository $backofficeUserRepository,
        PasswordResetService     $passwordResetService
    ) {
        $this->mailer = $mailer;
        $this->backofficeUserForm = $backofficeUserForm;
        $this->userRepository = $userRepository;
        $this->positionRepository = $positionRepository;
        $this->permissionRepository = $permissionRepository;
        $this->branchOfficeRepository = $branchOfficeRepository;
        $this->backofficeUserRepository = $backofficeUserRepository;
        $this->extraPermissionService = $extraPermissionService;
        $this->passwordResetService = $passwordResetService;
    }

    public function getDataTableData($filters = [], $isAdmin = false)
    {
        $data = $this->backofficeUserRepository->all($filters, $isAdmin);
        return DataTables::of($data)->make(true);
    }

    public function getFormData(BackofficeUser $backofficeUserModel = null): array
    {
        $data = [
            'positions' => $this->positionRepository->all()
                ->pluck('name', 'id'),
            'permissions' => $this->permissionRepository->all()
                ->pluck('name', 'id'),
            'branch_offices' => $this->branchOfficeRepository->all()
                ->pluck('name', 'id'),
            'superiors' => $this->backofficeUserRepository->getSuperiorQuery()
                ->pluck('name', 'id'),
        ];

        if ($backofficeUserModel) {
            $extraPermissions = $this->extraPermissionService->getRepository()
                ->getExtraPermissions($backofficeUserModel->getId())
                ->pluck('permission_id');
            $data = array_merge($data, [
                'values' => [
                    'user_id' => $backofficeUserModel->getUserId(),
                    'first_name' => $backofficeUserModel->getFirstName(),
                    'last_name' => $backofficeUserModel->getLastName(),
                    'email' => $backofficeUserModel->getEmail(),
                    'phone' => $backofficeUserModel->getPhone(),
                    'dob' => $backofficeUserModel->getDateOfBirth(),
                    'notified_name' => $backofficeUserModel->getNotifiedName(),
                    'notified_phone' => $backofficeUserModel->getNotifiedPhone(),
                    'superior_id' => $backofficeUserModel->getSuperiorId(),
                    'position_id' => $backofficeUserModel->getPositionId(),
                    'branch_office_id' => $backofficeUserModel->getBranchOfficeId(),
                    'main_permission_id' => $backofficeUserModel->getMainPermissionid(),
                    'extra_permission_ids' => $extraPermissions,
                ]
            ]);
        }

        return $data;
    }

    public function register($request)
    {
        try {
            DB::beginTransaction();
            $userModel = $this->userRepository->createFromRequest($request);

            $backofficeUserModel = $this->backofficeUserRepository
                ->createFromRequest($userModel, $request);

            $this->extraPermissionService
                ->updateExtraPermissions(
                    $backofficeUserModel,
                    $request->input('extra_permission_ids', []));

            $adminRole = Role::firstWhere('name', 'Admin');
            DB::table('model_has_roles')->insert([
                'role_id' => $adminRole->id,
                'model_type' => User::class,
                'model_id' => $userModel->getId()
            ]);

            DB::commit();
            return $backofficeUserModel;
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return false;
    }

    public function update(BackofficeUser $backofficeUserModel, $request, $profileUpdate = false): bool
    {
        try {
            DB::beginTransaction();
            $userModel = $this->userRepository
                ->getById($backofficeUserModel->getUserId());

            $this->userRepository->updateFromRequest($userModel, $request);
            $backofficeUserModel = $this->backofficeUserRepository
                ->updateFromRequest($backofficeUserModel, $request);
            $addPermissions = $request->input('extra_permission_ids', []);
            if (!$profileUpdate) {
                $this->extraPermissionService->updateExtraPermissions(
                    $backofficeUserModel,
                    $addPermissions
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function sendPasswordResetRequest(BackofficeUser $backofficeUserModel)
    {
        $userModel = $backofficeUserModel->user;

        if (!$userModel) {
            throw new \Exception();
        }

        $token = $this->passwordResetService->passwordRequest($userModel);

        $arrData = [
            "first_name" => $backofficeUserModel->getFirstName(),
            "reset_url" => route('backoffice.user.password.reset', ['token' => $token]),
            "from_name" =>  config('app.name'),
        ];

        Mailer::send($userModel, EmailTemplate::Password_Reset, $arrData);

        return $userModel->update([
            'is_verified' => false,
            'is_active' => false
        ]);
    }

    public function sendCreatePasswordResetRequest(BackofficeUser $backofficeUserModel)
    {
        $userModel = $backofficeUserModel->user;

        if (!$userModel) {
            throw new \Exception();
        }

        $token = $this->passwordResetService->passwordRequest($userModel);

        $arrData =  [
            'reset_url' => route('backoffice.user.password.reset', ['token' => $token]),
            'first_name' => $backofficeUserModel->getFirstName(),
            'last_name' => $backofficeUserModel->getLastName()
        ];

        Mailer::send($userModel, EmailTemplate::BackofficeUserNewPassword, $arrData);

        return $userModel->update([
                                      'is_verified' => false,
                                      'is_active' => false
                                  ]);
    }

    /**
     * @throws \Exception
     */
    public function updatePassword(BackofficeUser $backofficeUserModel, $request)
    {
        $newPassword = $request->input('new_password');
        $newPasswordConfirm = $request->input('new_password_confirmation');

        if ($newPassword !== $newPasswordConfirm) {
            return false;
        }

        $user = $backofficeUserModel->user;

        return $user->update([
            'password' => Hash::make($newPassword),
            'is_verified' => true,
            'is_active' => true
        ]);
    }

    public function getFormData2(BackofficeUser $backofficeUserModel = null)
    {
        return $this->backofficeUserForm->getFormData($backofficeUserModel);
    }

    public function getRepository(): BackofficeUserRepository
    {
        return $this->backofficeUserRepository;
    }
}
