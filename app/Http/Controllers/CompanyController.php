<?php

namespace App\Http\Controllers;

use App\Helpers\Video;
use App\Http\Requests\CompanyBatchUpdateStatus;
use App\Http\Requests\CompanyRegisterAdminRequest;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Factories\ActivityLogFactory;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CityFactory;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\JobApplicationFactory;
use App\Models\Factories\PositionFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\Factories\UserFactory;
use App\Models\FeaturedRecord;
use App\Models\FrontSetting;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Position;
use App\Models\ReportedToCompany;
use App\Models\State;
use App\Models\Transaction;
use App\Queries\ReportedCompanyDataTable;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CompanyController extends AppBaseController
{
    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Company.
     *
     * @param Request $request
     *
     * @return Factory|View
     * @throws Exception
     *
     */
    public function index(Request $request)
    {
        $data = $this->companyRepository->get();
        $featured = Company::IS_FEATURED;
        $statusArr = Company::STATUS;

        return view('companies.index', compact('data', 'featured', 'statusArr'));
    }

    public function getCompanyData(Request $request)
    {
        $companyFactory = new CompanyFactory();
        $data = $companyFactory->getAllFormatted();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new Company.
     *
     * @return Factory|View
     */
    public function create()
    {
        $data = $this->companyRepository->prepareData();
        $countries = Country::pluck('name', 'id');
        $states = State::toBase()->pluck('name', 'id');
        $isGoogleReCaptchaEnabled = false;
        $arrPositions = Position::toBase()->orderBy('name', 'asc')->pluck('name', 'id');


        return view('companies.create', compact('countries', 'states', 'arrPositions', 'isGoogleReCaptchaEnabled'))->with(
            'data',
            $data
        );
    }

    /**
     * Store a newly created Company in storage.
     *
     * @param CompanyRegisterAdminRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CompanyRegisterAdminRequest $request)
    {
        $input = $request->all();
        $input['is_active'] = 1;
        $input['is_verified'] = 1;

        $company = $this->companyRepository->store($input);

        Flash::success(trans('messages.admin.company.created'));

        return redirect(route('company.index'));
    }

    /**
     * Display the specified Company.
     *
     * @param Company $company
     *
     * @return Factory|View
     */
    public function show(Company $company)
    {
        return view('companies.show')->with('company', $company);
    }

    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     *
     */
    public function getCompanyApplicationData(Request $request, $company_id)
    {
        $JobApplicationFactory = new JobApplicationFactory();
        $CompanyFactory = new CompanyFactory();
        $objCandidate = $CompanyFactory->getById($company_id);
        $data = $JobApplicationFactory->getApplicationsByCompany($objCandidate);

        return DataTables::of($data)->make(true);
    }

    public function batchStatusUpdate(CompanyBatchUpdateStatus $request)
    {
        try {
            $post = $request->post();
            $companyFactory = new CompanyFactory();
            $userFactory = new UserFactory();
            foreach ($post['companies'] as $companyId) {
                $objCompany = $companyFactory->getById($companyId);
                if (!$objCompany) {
                    throw new Exception('Invalid company id specified');
                }
                $objUser = $userFactory->getById($objCompany->getUserId());
                if (!$objUser) {
                    throw new Exception('Invalid user id specified');
                }

                if (!$userFactory->changeStatus($objUser, $post['status'])) {
                    throw new Exception('Failed to change status');
                }
            }
        } catch (Exception $e) {
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }
        $this->ajaxresponse('success', '', []);
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param Company $company
     *
     * @return Factory|View
     */
    public function edit(Company $company, Request $request)
    {
        $user = $company->user;
        $user->phone = preparePhoneNumber($user->phone, $user->region_code);
        $data = $this->companyRepository->prepareData();
        $countries = Country::pluck('name', 'id');
        $states = State::toBase()->pluck('name', 'id');
        $state = $cities = null;
        $objLastActivity = (new ActivityLogFactory())->getLatestByCompanyId($company->id);
        if (isset($user->country_id)) {
            $state = getStates($user->country_id);
        }
        if (isset($user->state_id)) {
            $cities = getCities($user->state_id);
        }

        $sectionName = ($request->section === null) ? 'profile' : $request->section;
        $data['sectionName'] = $sectionName;

        if (!view()->exists('companies.profile.' . $sectionName)) {
            $sectionName = 'profile';
        }

        $postcode = $city = $mailingPostcode = $mailingCity = $representativePosition = null;
        $postcodeFactory = new PostalCodeFactory();
        $cityFactory = new CityFactory();
        $positionFactory = new PositionFactory();

        if (isset($company->postcode_id)) {
            $postcode = $postcodeFactory->getById($company->postcode_id);
        }
        if (isset($company->city_id)) {
            $city = $cityFactory->getById($company->city_id);
        }
        if (isset($company->mailing_postcode_id)) {
            $mailingPostcode = $postcodeFactory->getById($company->mailing_postcode_id);
        }
        if (isset($company->mailing_city_id)) {
            $mailingCity = $cityFactory->getById($company->mailing_city_id);
        }

        if (isset($user->position_id)) {
            $representativePosition = $positionFactory->getById($user->position_id);
        }
        switch ($sectionName) {
            default:
            {
                break;
            }
        }

        return view(
            'companies.profile.' . $sectionName,
            compact(
                'objLastActivity',
                'representativePosition',
                'postcode',
                'city',
                'mailingPostcode',
                'mailingCity',
                'data',
                'company',
                'cities',
                'state',
                'user',
                'countries',
                'states'
            )
        );
    }

    /**
     * @param Company $company
     * @param UpdateCompanyRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     *
     */
    public function update(Company $company, UpdateCompanyRequest $request)
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;

        $updatedCompany = $this->companyRepository->update($input, $company);
        $userId = Auth::user()->id;

        $objUser = (new UserFactory())->getById($userId);

        activity()
            ->inLog("custom")
            ->performedOn($company)
            ->log('Cégprofil módosítás')
            ->causer($objUser);

        Flash::success(trans('messages.company.updated_successfully'));

        return redirect(route('company.index'));
    }

    /**
     * Remove the specified Company from storage.
     *
     * @param Company $company
     *
     * @return RedirectResponse|Redirector
     * @throws Exception
     *
     */
    public function destroy(Company $company)
    {
        $this->companyRepository->delete($company->id);
        $company->user->media()->delete();
        $company->user->delete();

        return $this->sendSuccess('Company deleted successfully.');
    }

    public function softDeleteCompany(Request $request){
        $arrData   = $request->post();
        $validator = Validator::make($arrData, [
            'companyId' => 'required|numeric|exists:companies,id',
        ]);

        if ($validator->fails()) {
            $this->ajaxresponse('error', trans('messages.company.delete_error_invalid_company'));
        }

        $objCompany = (new CompanyFactory())->getById($arrData['companyId']);

        if (!$objCompany) {
            $this->ajaxresponse('error', trans('messages.company.delete_error_invalid_company'));
        }

        $objUser = (new UserFactory())->getById($objCompany->getUserId());
        $userRepository = new UserRepository();

        DB::beginTransaction();

        if (!$objUser) {
            $this->ajaxresponse('error', trans('messages.company.delete_error_missing_user'));
            return;
        }
        if(!$this->companyRepository->softDelete($objCompany) || !$userRepository->softDelete($objUser)) {
            $this->ajaxresponse('error', trans('messages.company.delete_error_generic'));
            return;
        }

        DB::commit();

        $this->ajaxresponse('success', trans('messages.company.delete_success'));
    }

    /**
     * @param Company $company
     *
     * @return mixed
     */
    public function changeIsActive(Company $company)
    {
        $isActive = $company->user->is_active;
        $company->user->update(['is_active' => !$isActive]);

        return $this->sendSuccess('Status changed successfully.');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getStates(Request $request)
    {
        $postal = $request->get('postal');

        $states = getStates($postal);

        return $this->sendResponse($states, 'Retrieved successfully');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getCities(Request $request)
    {
        $state = $request->get('state');
        $cities = getCities($state);

        return $this->sendResponse($cities, 'Retrieved successfully');
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param Company $company
     *
     * @return Factory|View
     */
    public function editCompany(Company $company)
    {
        $user = $company->user;
        $user->phone = preparePhoneNumber($user->phone, $user->region_code);
        if ($user->id != getLoggedInUserId()) {
            throw new ModelNotFoundException;
        }
        $data = $this->companyRepository->prepareData();
        $postcode = $city = $mailingPostcode = $mailingCity = null;
        $postcodeFactory = new PostalCodeFactory();
        $cityFactory = new CityFactory();

        if (isset($company->postcode_id)) {
            $postcode = $postcodeFactory->getById($company->postcode_id);
        }
        if (isset($company->city_id)) {
            $city = $cityFactory->getById($company->city_id);
        }
        if (isset($company->mailing_postcode_id)) {
            $mailingPostcode = $postcodeFactory->getById($company->mailing_postcode_id);
        }
        if (isset($company->mailing_city_id)) {
            $mailingCity = $cityFactory->getById($company->mailing_city_id);
        }
        $isFeaturedEnable = FrontSetting::where('key', 'featured_companies_enable')->first()->value;
        $maxFeaturedJob = FrontSetting::where('key', 'featured_companies_quota')->first()->value;
        $totalFeaturedJob = Company::Has('activeFeatured')->count();
        $isFeaturedAvilabal = ($totalFeaturedJob >= $maxFeaturedJob) ? false : true;


        return view(
            'employer.companies.edit',
            compact(
                'data',
                'company',
                'city',
                'postcode',
                'mailingCity',
                'mailingPostcode',
                'user',
                'isFeaturedEnable',
                'isFeaturedAvilabal'
            )
        );
    }

    /**
     * Update the specified Company in storage.
     *
     * @param Company $company
     * @param UpdateEmployerRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function updateCompany(Company $company, UpdateEmployerRequest $request)
    {

        $input = $request->all();
        $updatedCompany = $this->companyRepository->update($input, $company);

        $userId = Auth::user()->id;

        $objUser = (new UserFactory())->getById($userId);

        activity()
            ->inLog("custom")
            ->performedOn($company)
            ->log('Cégprofil módosítás')
            ->causer($objUser);

        Flash::success(trans('messages.company.profile_updated_successfully'));

        return redirect(route('company.edit.form', Auth::user()->owner_id));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     * @throws Exception
     *
     */
    public function showReportedCompanies(Request $request)
    {
        $reportedEmployee = ReportedToCompany::all();

        return view('employer.companies.reported_companies', compact('reportedEmployee'));
    }

    /**
     * @param ReportedToCompany $reportedToCompany
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function deleteReportedCompany(ReportedToCompany $reportedToCompany)
    {
        $reportedToCompany->delete();

        return $this->sendSuccess('Reported Jobs deleted successfully.');
    }

    /**
     * Display a listing of the Job.
     *
     * @param Request $request
     *
     * @return Factory|View
     * @throws Exception
     *
     */
    public function getFollowers(Request $request)
    {
        return view('employer.followers.index');
    }

    /**
     * @param ReportedToCompany $reportedToCompany
     *
     * @return mixed
     */
    public function showReportedCompanyNote(Request $request)
    {
        $data = $this->companyRepository->getReportedToCompany($request->reportedToCompany);
        $data['date'] = \Carbon\Carbon::parse($data->created_at)->formatLocalized('%d %b, %Y');

        return $this->sendResponse($data, 'Retrieved successfully.');
    }

    /**
     * @param  $companyId
     *
     * @return mixed
     **/
    public function markAsFeatured($companyId)
    {
        $user = getLoggedInUser();
        $addDays = FrontSetting::where('key', 'featured_companies_days')->first()->value;
        $price = FrontSetting::where('key', 'featured_companies_price')->first()->value;
        $maxFeaturedJob = FrontSetting::where('key', 'featured_companies_quota')->first()->value;
        $totalFeaturedJob = Company::Has('activeFeatured')->count();
        $isFeaturedAvailable = ($totalFeaturedJob >= $maxFeaturedJob) ? false : true;
        $company = Company::with('user')->findOrFail($companyId);

        if ($isFeaturedAvailable) {
            $featuredRecord = [
                'owner_id' => $companyId,
                'owner_type' => Company::class,
                'user_id' => $user->id,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays($addDays),
            ];
            FeaturedRecord::create($featuredRecord);
            NotificationSetting::whereKey(Notification::MARK_COMPANY_FEATURED_ADMIN)->where(
                'type',
                'admin'
            )->first()->value == 1 ?
                addNotification([
                                    Notification::MARK_COMPANY_FEATURED_ADMIN,
                                    $company->user->id,
                                    Notification::EMPLOYER,
                                    $user->first_name . ' ' . $user->last_name . ' mark Company as Featured.',
                                ]) : false;
            $transaction = [
                'owner_id' => $companyId,
                'owner_type' => Company::class,
                'user_id' => $user->id,
                'amount' => $price,
            ];
            Transaction::create($transaction);

            return $this->sendSuccess('Company mark as featured successfully.');
        }

        return $this->sendError('Featured Quota is Not available');
    }

    /**
     * @param  $companyId
     *
     * @return mixed
     **/
    public function markAsUnFeatured($companyId)
    {
        /** @var FeaturedRecord $unFeatured */
        $unFeatured = FeaturedRecord::where('owner_id', $companyId)->where('owner_type', Company::class)->first();
        $unFeatured->delete();

        return $this->sendSuccess('Company mark as Unfeatured successfully.');
    }

    /**
     * @param Company $company
     *
     * @return mixed
     */
    public function changeIsEmailVerified(Company $company)
    {
        $company->user->update(['email_verified_at' => Carbon::now()]);

        return $this->sendSuccess('Email verified successfully.');
    }

    /**
     * @param Company $company
     *
     * @return mixed
     */
    public function resendEmailVerification(Company $company)
    {
        $company->user->sendEmailVerificationNotification();

        return $this->sendSuccess('Verification mail resent successfully.');
    }

    public function uploadGalleryImage(Request $request)
    {
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'gallery.*' => 'required|image|max:20000',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag()->toArray();
            return response()->json(array(
                                        'success' => false,
                                        'errors' => $validator->errors()->first()

                                    ), 500);
        }
    }
}
