<?php

namespace App\Http\Controllers\Backoffice;

use App\Helpers\Mailer;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Backoffice\CreateBackofficeUserRequest;
use App\Http\Requests\BackofficeUserBatchUpdateStatus;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Lib\Backoffice\User\BackofficeUserService;
use App\Lib\PasswordReset\PasswordResetService;
use App\Models\BackofficeUser;
use App\Models\EmailTemplate;
use App\Models\Factories\BackofficeUserFactory;
use App\Models\Factories\UserFactory;
use Auth;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Throwable;

/**
 * Class UserController
 */
class BackofficeUserController extends AppBaseController
{
    private $mailer;

    /** @var BackofficeUserService */
    private $backofficeUserService;

    /**
     * @var PasswordResetService
     */
    private $passwordResetService;

    public function __construct(
        Mailer $mailer,
        BackofficeUserService $backofficeUserService,
        PasswordResetService $passwordResetService
    ) {
        $this->mailer = $mailer;
        $this->backofficeUserService = $backofficeUserService;
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        $isAdmin = false;
        $user = Auth::user();

        if ($user) {
            $backofficeUserModel = $this->backofficeUserService
                ->getRepository()
                ->findByUserId($user->getId());
            $isAdmin = $backofficeUserModel ? $backofficeUserModel->isAdmin() : false;
        }

        if ($request->ajax()) {
            $filters = $request->input('filters');
            return $this->backofficeUserService->getDataTableData($filters, $isAdmin);
        }

        $filters = [
            [
                'id' => 'backofficeUserFilterPositionId',
                'class_size' => 'col-sm-3',
                'name' => 'position_id',
                'title' => 'messages.backoffice.user.position',
                'type' => 'select2_ajax',
                'multiple' => true,
                'ajaxUrl' => 'select2.backofficePositions',
                'value' => []
            ],
            [
                'id' => 'backofficeUserFilterBranchOfficeId',
                'class_size' => 'col-sm-3',
                'name' => 'branch_office_id',
                'title' => 'messages.backoffice.user.branch_office',
                'type' => 'select2_ajax',
                'multiple' => true,
                'ajaxUrl' => 'select2.backofficeBranchOffices',
                'value' => []
            ],
            [
                'id' => 'backofficeUserFilterSuperiorId',
                'class_size' => 'col-sm-3',
                'name' => 'superior_id',
                'title' => 'messages.backoffice.user.superior',
                'type' => 'select2_ajax',
                'multiple' => true,
                'ajaxUrl' => 'select2.backofficeSuperiors',
                'value' => []
            ],
            [
                'id' => 'backofficeUserFilterPermissionId',
                'class_size' => 'col-sm-3',
                'name' => 'main_permission_id',
                'title' => 'messages.backoffice.user.main_permission',
                'type' => 'select2_ajax',
                'multiple' => true,
                'ajaxUrl' => 'select2.permissions',
                'value' => []
            ],
        ];

        return view('backoffice.user.index')
            ->with('filters', $filters)
            ->with('isAdmin', $isAdmin)
            ;
    }

    public function create()
    {
        $formData = $this->backofficeUserService->getFormData2();
        $formData['action'] = 'backofficeuser.store';

        return view('backoffice.user.create')->with('form', $formData);
    }

    public function store(CreateBackofficeUserRequest $request)
    {
        $backofficeUser = $this->backofficeUserService->register($request);
        $this->backofficeUserService->sendCreatePasswordResetRequest($backofficeUser);

        if ($backofficeUser) {
            Flash::success(trans('messages.backoffice.user.successfully_saved'));
        } else {
            Flash::error(trans('messages.backoffice.user.unsuccessfully_save'));
        }

        activity()
            ->inLog('custom')
            ->performedOn($backofficeUser)
            ->log('Backoffice User Létrehozása')
            ->causer(Auth::user());

        return redirect(route('backoffice.user.index', ['backofficeUserModel' => $backofficeUser->id]));
    }

    public function edit(BackofficeUser $backofficeUserModel)
    {
        $data = $this->backofficeUserService->getFormData2($backofficeUserModel);
        $data['title'] = 'edit_backoffice_user';
        $data['action'] = ['backoffice.user.update', $backofficeUserModel->getId()];

        return view('backoffice.user.create')
            ->with('user', $backofficeUserModel)
            ->with('form', $data);
    }

    public function update(CreateBackofficeUserRequest $request, BackofficeUser $backofficeUserModel)
    {
        $id = $backofficeUserModel->getId();
        $update = $this->backofficeUserService
            ->update($backofficeUserModel, $request);

        if ($update) {
            Flash::success(__('messages.backoffice.user.successfully_updated'));
            activity()
                ->inLog('custom')
                ->performedOn($backofficeUserModel)
                ->log('Backoffice User Módosítása')
                ->causer(Auth::user());
        } else {
            Flash::success(__('messages.unsuccessfully_update'));
        }

        return redirect(route('backoffice.user.index', []));
    }

    public function passwordChangeRequest(BackofficeUser $backofficeUserModel)
    {
        $this->backofficeUserService->sendPasswordResetRequest($backofficeUserModel);

        activity()
            ->inLog('custom')
            ->performedOn($backofficeUserModel)
            ->log('Backoffice User új jelszó igénylése')
            ->causer(Auth::user());

        return $this->sendSuccess(trans('messages.password_change_request_sent'));
    }

    public function passwordResetForm(PasswordResetRequest $request, $token)
    {
        $passwordResetModel = $this->passwordResetService
            ->getRepository()->getByToken($token);

        if (!$passwordResetModel ) {
            return redirect()->route('admin.login');
        }

        $userModel = $this->backofficeUserService
            ->getRepository()->findByEmail($passwordResetModel->getEmail());

        if (!$userModel) {
            return redirect()->route('admin.login');
        }

        return view('backoffice.user.password-reset')
            ->with('token', $passwordResetModel->token)
            ->with('userModel', $userModel);
    }

    /**
     * @throws Exception
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $passwordResetModel = $this->passwordResetService
            ->getRepository()->getByToken($request->input('token'));

        if (!$passwordResetModel) {
            return redirect()->route('admin.login');
        }

        $userModel = $this->backofficeUserService
            ->getRepository()->findByEmail($passwordResetModel->getEmail());

        if (!$userModel) {
            return redirect()->route('admin.login');
        }

        $updated = $this->backofficeUserService->updatePassword($userModel, $request);

        if ($updated) {
            Flash::success(__('messages.backoffice.user.successfully_added_new_password'));
            $passwordResetModel->delete();
        } else {
            return redirect()->back();
        }

        activity()
            ->inLog('custom')
            ->performedOn($userModel)
            ->log('Backoffice felhasználó aktiválva lett')
            ->causer(Auth::user());

        return view('auth.login');
    }

    /**
     * Show the form for editing the specified User.
     *
     * @return JsonResponse
     */
    public function editProfile()
    {
        $user = Auth::user();

        $backofficeUserModel = $this->backofficeUserService
            ->getRepository()
            ->findByUserId($user->getId());

        if (!$backofficeUserModel) {
            throw new \Exception();
        }

        $backofficeUserModel->load('superior', 'branchOffice', 'position');



        return $this->sendResponse($backofficeUserModel, 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified User.
     *
     * @return JsonResponse
     */
    public function updateProfile(CreateBackofficeUserRequest $request)
    {
        $user = Auth::user();

        $backofficeUserModel = $this->backofficeUserService
            ->getRepository()
            ->findByUserId($user->getId());

        if (!$backofficeUserModel) {
            throw new \Exception();
        }

        $this->backofficeUserService->update(
            $backofficeUserModel,
            $request,
            true
        );

        activity()
            ->inLog('custom')
            ->performedOn($backofficeUserModel)
            ->log('Backoffice User módosítása')
            ->causer(Auth::user());

        return $this->sendResponse($backofficeUserModel, __("messages.backoffice.user.profile_updated_successfully"));
    }

    public function destroy(BackofficeUser $backofficeUserModel)
    {
        $backofficeUserModel->delete();
        $backofficeUserModel->user->delete();

        activity()
            ->inLog('custom')
            ->performedOn($backofficeUserModel)
            ->log('Backoffice User törlése')
            ->causer(Auth::user());

        return $this->sendSuccess('Backoffice User deleted successfully.');
    }

    public function batchStatusUpdate(BackofficeUserBatchUpdateStatus $request)
    {
        try {
            $post = $request->post();
            $backofficeUserFactory = new BackOfficeUserFactory();
            $userFactory = new UserFactory();
            foreach ($post['backoffice_users'] as $backofficeUserId) {
                $objBackOfficeUser = $backofficeUserFactory->getById($backofficeUserId);
                if (!$objBackOfficeUser) {
                    throw new Exception('Invalid backoffice user id specified');
                }
                $objUser = $userFactory->getById($objBackOfficeUser->getUserId());
                if (!$objUser) {
                    throw new Exception('Invalid user id specified');
                }

                if (!$userFactory->changeStatus($objUser, $post['status'])) {
                    throw new Exception('Failed to change status');
                }
            }
        } catch (Throwable $e) {
            dump($e->getMessage());
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }
        $this->ajaxresponse('success', '', []);
    }
}
