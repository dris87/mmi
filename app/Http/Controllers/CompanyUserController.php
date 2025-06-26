<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Http\Requests\CompanyUserBatchUpdateStatus;
use App\Http\Requests\UpdateCompanyUserRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\CompanySiteFactory;
use App\Models\Factories\CompanyUserFactory;
use App\Models\Factories\CoworkerPositionFactory;
use App\Models\Factories\PermissionFactory;
use App\Models\Factories\UserFactory;
use App\Repositories\UserRepository;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;

/**
 * Class CoworkerController
 */
class CompanyUserController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;
    /**
     * @var CompanyFactory
     */
    private CompanyFactory $companyFactory;
    /**
     * @var CompanyUserFactory
     */
    private CompanyUserFactory $companyUserFactory;
    /**
     * @var PermissionFactory
     */
    private PermissionFactory $permissionFactory;
    /**
     * @var CoworkerPositionFactory
     */
    private CoworkerPositionFactory $coworkerPositionFactory;
    /**
     * @var CompanySiteFactory
     */
    private CompanySiteFactory $companySiteFactory;

    /**
     * @param UserRepository $userRepo
     * @param CompanyUserFactory $companyUserFactory
     * @param CompanyFactory $companyFactory
     * @param PermissionFactory $permissionFactory
     * @param CoworkerPositionFactory $coworkerPositionFactory
     * @param CompanySiteFactory $companySiteFactory
     */
    public function __construct(
        UserRepository $userRepo,
        CompanyUserFactory $companyUserFactory,
        CompanyFactory $companyFactory,
        PermissionFactory $permissionFactory,
        CoworkerPositionFactory $coworkerPositionFactory,
        CompanySiteFactory $companySiteFactory
    )
    {
        $this->userRepository = $userRepo;
        $this->companyUserFactory = $companyUserFactory;
        $this->companyFactory = $companyFactory;
        $this->permissionFactory = $permissionFactory;
        $this->coworkerPositionFactory = $coworkerPositionFactory;
        $this->companySiteFactory = $companySiteFactory;
    }

    /**
     * @throws Exception
     */
    public function list(){

        $data = $this->companyUserFactory->getByCompanyFormatted(UserHelper::getCompany());

        return view('employer.coworkers.index', compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getCompanyData(Request $request)
    {
        $data = $this->companyUserFactory->getByCompanyFormatted(UserHelper::getCompany());
        return DataTables::of($data)->make(true);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function deleteCompanyUser(Request $request){
        $arrData   = $request->post();
        $validator = Validator::make($arrData, [
            'companyUserId' => 'required|numeric|exists:company_users,id',
        ]);

        if ($validator->fails()) {
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_invalid_company_user'));
        }

        $objCompanyUser = (new CompanyUserFactory())->getById($arrData['companyUserId']);

        if (!$objCompanyUser) {
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_invalid_company_user'));
        }

        $objCompany = $this->companyFactory->getById($objCompanyUser->getCompanyId());

        DB::beginTransaction();

        if (!$objCompany) {
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_missing_company'));
            return;
        }

        if(!$this->companyUserFactory->getByCompany($objCompany, [$objCompanyUser->getId()])){
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_at_least_one_required'));
            return;
        }
        $permissionFactory = new PermissionFactory();
        $objPermission = $permissionFactory->getFrontOfficeAdminPermission();

        if(!$objPermission) {
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_missing_admin_permission'));
            return;
        }
        if(!$this->companyUserFactory->getByCompanyAndPermission($objCompany, $objPermission, [$objCompanyUser->getId()])){
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_at_least_one_admin_required'));
            return;
        }
        if(!$this->companyUserFactory->delete($objCompanyUser)) {
            $this->ajaxresponse('error', trans('messages.coworker.delete_error_generic'));
            return;
        }

        DB::commit();

        $this->ajaxresponse('success', trans('messages.coworkers.delete_success'));
    }

    /**
     * Show the form for editing the specified Company User.
     *
     * @param Request $request
     * @param $companyUserId
     * @return Application|Factory|View
     */
    public function edit(Request $request, $companyUserId)
    {
        $objCompanyUser = $this->companyUserFactory->getById($companyUserId);
        if(!$objCompanyUser) {
            throw new Exception(trans('messages.coworker.edit_error_invalid_company_user'));
        }
        $objCompany = $this->companyFactory->getById($objCompanyUser->getCompanyId());
        $objUser = $this->userRepository->getById($objCompanyUser->getUserId());
        $arrPermissions = $this->permissionFactory->getFrontOfficePermissions();
        $arrPositions = $this->coworkerPositionFactory->getAll();
        $arrCompanySites = $this->companySiteFactory->getByCompanyFormatted($objCompany);

        $arrCompanySiteSelect = [];

        if($arrCompanySites) {
            foreach ($arrCompanySites as $companySite) {
                $arrCompanySiteSelect[$companySite['id']] = $companySite['site'];
            }
        }

        $arrPositionSelect = [];

        if($arrPositions){
            foreach($arrPositions as $ObjPosition) {
                $arrPositionSelect[$ObjPosition->getId()] = $ObjPosition->getName();
            }
        }

        $arrPermissionSelect = [];

        if($arrPermissions) {
            foreach ($arrPermissions as $objPermission) {
                $arrPermissionSelect[$objPermission->getId()] = $objPermission->getName();
            }
        }

        return view('company_users.edit')->with([
            'objCompanyUser' => $objCompanyUser,
            'objUser' => $objUser,
            'objCompany' => $objCompany,
            'arrPermissions' => $arrPermissionSelect,
            'arrPositions' => $arrPositionSelect,
            'arrCompanySites' => $arrCompanySiteSelect
        ]);
    }

    /**
     * @param UpdateCompanyUserRequest $request
     * @param $companyUserId
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function update(UpdateCompanyUserRequest $request, $companyUserId){

        $post = $request->all();

        $userFactory = new UserFactory();

        $objCompanyUser = $this->companyUserFactory->getById($companyUserId);
        $objUser = $userFactory->getById($objCompanyUser->getUserId());
        $objCompany = $this->companyFactory->getById($objCompanyUser->getCompanyId());

        if(!$objCompanyUser) {
            throw new Exception(trans('messages.coworker.edit_error_invalid_company_user'));
        }

        if(!$objUser) {
            throw new Exception(trans('messages.coworker.edit_error_invalid_company_user'));
        }

        $objPermission = $this->permissionFactory->getById($post['permission_id']);

        if(!$objPermission) {
            throw new Exception(trans('messages.coworker.invalid_permission'));
        }

        $objPosition = $this->coworkerPositionFactory->getById($post['position_id']);

        if(!$objPosition){
            throw new Exception(trans('messages.coworker.invalid_coworker_position'));
        }

        $objCompanySite = null;

        if(isset($post['company_site_id'])){
            $objCompanySite = $this->companySiteFactory->getById($post['company_site_id']);
            if(!$objCompanySite) {
                throw new Exception(trans('messages.coworker.invalid_company_site'));
            }
        }

        DB::beginTransaction();

        if(!$userFactory->updateBasicInfo($objUser, $post['first_name'], $post['last_name'], $post['email'])){
            DB::rollBack();
            throw new Exception(trans('messages.common.process_failed'));
        }

        if(!$this->companyUserFactory->update($objCompanyUser, $objUser, $objCompany, $objPermission, $objPosition, $post['phone'], $post['is_active'], $objCompanySite)){
            DB::rollBack();
            throw new Exception(trans('messages.common.process_failed'));
        }

        DB::commit();

        Flash::success(trans('messages.coworker.edited_successfully'));

        activity()
            ->inLog('custom')
            ->performedOn($objCompanyUser)
            ->log('Munkatárs módosítás')
            ->causer(Auth::user());

        return redirect(route('company.edit', $objCompany->getId()).'?section=company_users');
    }

    /**
     * @param CompanyUserBatchUpdateStatus $request
     * @return void
     */
    public function batchStatusUpdate(CompanyUserBatchUpdateStatus $request)
    {
        DB::beginTransaction();

        $objPermission = $this->permissionFactory->getFrontOfficeAdminPermission();

        try {

            $post = $request->post();

            foreach ($post['company_users'] as $companyUserId) {

                $objCompanyUser = $this->companyUserFactory->getById($companyUserId);
                $objCompany = $this->companyFactory->getById($objCompanyUser->getCompanyId());

                if (!$objCompanyUser) {
                    throw new Exception('Invalid company id specified');
                }

                if($post['status'] == 0 && !$this->companyUserFactory->getByCompanyAndPermission($objCompany, $objPermission, [$objCompanyUser->getId()])) {
                    $this->ajaxresponse('error', trans('messages.coworker.delete_error_at_least_one_admin_required_active'));
                }
                else {
                    if (!$this->companyUserFactory->changeStatus($objCompanyUser, $post['status'])) {
                        throw new Exception('Failed to change status');
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }

        DB::commit();

        $this->ajaxresponse('success', '', []);
    }
}
