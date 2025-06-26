<?php

namespace App\Http\Controllers\Candidates;

use Illuminate\Http\Response;
use App;
use App\Helpers\Mailer;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CandidateBatchStatusUpdate;
use App\Http\Requests\CandidateUpdateGeneralInformationRequest;
use App\Http\Requests\CandidateUpdateOnlineProfileRequest;
use App\Http\Requests\CandidateUpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateCandidateProfileRequest;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateSkill;
use App\Models\EmailTemplate;
use App\Models\Factories\ActivityLogFactory;
use App\Models\Factories\CandidateAdvancedItSkillsFactory;
use App\Models\Factories\CandidateBasicItSkillsFactory;
use App\Models\Factories\CandidateExtraQualificationsFactory;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CandidateLanguageFactory;
use App\Models\Factories\CandidateSoftwareSkillsFactory;
use App\Models\Factories\CandidateStatusFactory;
use App\Models\Factories\CityFactory;
use App\Models\Factories\LanguageFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\Factories\UserFactory;
use App\Models\JobApplication;
use App\Models\JobApplicationSchedule;
use App\Models\RequiredDegreeLevel;
use App\Models\User;
use App\Queries\CandidateAppliedJobDataTable;
use App\Queries\EmailTemplateDataTable;
use App\Queries\FavouriteCompanyDataTable;
use App\Queries\FavouriteJobDataTable;
use App\Repositories\Candidates\CandidateRepository;
use Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Mpdf\Exception\FontException;
use Mpdf\MpdfException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\MediaLibrary\Support\MediaStream;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isEmpty;

/**
 *
 */
class CandidateController extends AppBaseController
{
    /** @var CandidateRepository */
    private $candidateRepository;

    /**
     * CandidateController constructor.
     * @param CandidateRepository $candidateRepo
     */
    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }


    /**
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function my_resumes(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $candidate = (new CandidateFactory())->getByUser($user);
        $LanguageFactory = new LanguageFactory();
        $CandidateStatusFactory = new CandidateStatusFactory();
        $CityFactory = new CityFactory();
        $PostalCodeFactory = new PostalCodeFactory();
        $arrCandidateStatuses = $CandidateStatusFactory->collectionToIndexedArray($CandidateStatusFactory->getAll());
        $arrLanguages = $LanguageFactory->collectionToIndexedArray($LanguageFactory->getAll());
        $jsonLanguages = json_encode($arrLanguages);
        $objLastActivity = (new ActivityLogFactory())->getLastByCauser($user);
        $data = $this->candidateRepository->prepareData();
        $countries = getCountries();
        $states = $cities = null;
        if (!empty($user->country_id)) {
            $states = getStates($user->country_id);
        }
        if (isset($user->state_id)) {
            $cities = getCities($user->state_id);
        }

        $candidateSkills = $user->candidateSkill()->pluck('skill_id')->toArray();
        $candidateJobCategories = $candidate->candidateJobCategories()->pluck('job_category_id')->toArray();
        $candidateJobShifts = $candidate->candidateJobShift()->pluck('job_shift_id')->toArray();
        $candidateJobType = $candidate->candidateJobType()->pluck('job_type_id')->toArray();
        $candidateAbleToTravel = $candidate->candidateAbleToTravelCity()->pluck('city_id')->toArray();
        $candidateAbleToMove = $candidate->candidateAbleToMoveCity()->pluck('city_id')->toArray();
        $candidateCircumstances = $candidate->candidateCircumstances()->pluck('circumstances_id')->toArray();
        $candidateExtraRequirements = $candidate->candidateExtraRequirements()->pluck('requirement_id')->toArray();
        $candidateDrivingLicences = $candidate->candidateDrivingLicence()->pluck('driving_licence_id')->toArray();
        $objCandidateExtraQualifications = (new CandidateExtraQualificationsFactory())->getByCandidate($candidate);
        $candidateLanguage = (new CandidateLanguageFactory())->getByUser($user)->toArray();
        $candidateBasicSkills = (new CandidateBasicItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateAdvancedSkills = (new CandidateAdvancedItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateSoftwareSkills = (new CandidateSoftwareSkillsFactory())->getByUser($candidate)->toArray();


        $objCity = $CityFactory->getById($candidate->city_id);
        $objPostCode = $PostalCodeFactory->getById($candidate->postcode_id);

        $postalCodeFactory = new PostalCodeFactory();
        $cityFactory = new CityFactory();


        return view(
            "candidate.profile.resumes",
            compact(
                "jsonLanguages",
                'arrCandidateStatuses',
                'objLastActivity',
                'candidateBasicSkills',
                'candidateAdvancedSkills',
                'candidateDrivingLicences',
                'candidateSoftwareSkills',
                'candidateAbleToTravel',
                'candidateCircumstances',
                'candidateAbleToMove',
                'objCandidateExtraQualifications',
                'candidateExtraRequirements',
                'objCity',
                'objPostCode',
                'candidate',
                'user',
                'data',
                'countries',
                'states',
                'cities',
                'candidateSkills',
                'candidateLanguage',
                'candidateJobCategories',
                'candidateJobShifts',
                'candidateJobType'
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return Factory|View
     * @throws Exception
     *
     */
    public function editProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $candidate = (new CandidateFactory())->getByUser($user);
        $LanguageFactory = new LanguageFactory();
        $CandidateStatusFactory = new CandidateStatusFactory();
        $CityFactory = new CityFactory();
        $PostalCodeFactory = new PostalCodeFactory();
        $arrCandidateStatuses = $CandidateStatusFactory->collectionToIndexedArray($CandidateStatusFactory->getAll());
        $arrLanguages = $LanguageFactory->collectionToIndexedArray($LanguageFactory->getAll());
        $jsonLanguages = json_encode($arrLanguages);
        $objLastActivity = (new ActivityLogFactory())->getLastByCauser($user);
        $data = $this->candidateRepository->prepareData();
        $countries = getCountries();
        $states = $cities = null;
        if (!empty($user->country_id)) {
            $states = getStates($user->country_id);
        }
        if (isset($user->state_id)) {
            $cities = getCities($user->state_id);
        }

        $candidateSkills = $user->candidateSkill()->pluck('skill_id')->toArray();
        $candidateJobCategories = $candidate->candidateJobCategories()->pluck('job_category_id')->toArray();
        $candidateJobShifts = $candidate->candidateJobShift()->pluck('job_shift_id')->toArray();
        $candidateJobType = $candidate->candidateJobType()->pluck('job_type_id')->toArray();
        $candidateAbleToTravel = $candidate->candidateAbleToTravelCity()->pluck('city_id')->toArray();
        $candidateAbleToMove = $candidate->candidateAbleToMoveCity()->pluck('city_id')->toArray();
        $candidateCircumstances = $candidate->candidateCircumstances()->pluck('circumstances_id')->toArray();
        $candidateExtraRequirements = $candidate->candidateExtraRequirements()->pluck('requirement_id')->toArray();
        $candidateDrivingLicences = $candidate->candidateDrivingLicence()->pluck('driving_licence_id')->toArray();
        $objCandidateExtraQualifications = (new CandidateExtraQualificationsFactory())->getByCandidate($candidate);
        $candidateLanguage = (new CandidateLanguageFactory())->getByUser($user)->toArray();
        $candidateBasicSkills = (new CandidateBasicItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateAdvancedSkills = (new CandidateAdvancedItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateSoftwareSkills = (new CandidateSoftwareSkillsFactory())->getByUser($candidate)->toArray();

        $sectionName = ($request->section === null) ? 'general' : $request->section;
        $data['sectionName'] = $sectionName;

        $objCity = $CityFactory->getById($candidate->city_id);
        $objPostCode = $PostalCodeFactory->getById($candidate->postcode_id);

        if ($sectionName == 'resumes') {
            /** @var Candidate $candidate */
            $candidate = Candidate::findOrFail($user->candidate->id);
            $data['resumes'] = $candidate->getMedia('resumes');
        }
        $postalCodeFactory = new PostalCodeFactory();
        $cityFactory = new CityFactory();
        if ($sectionName == 'career_informations' || $sectionName == 'cv_builder') {
            $data['candidateExperiences'] = CandidateExperience::where(
                'candidate_id',
                $user->owner_id
            )->orderByDesc('id')->get();

            foreach ($data['candidateExperiences'] as $experience) {
                $experience->country = getCountryName($experience->country_id);
                if ($experience->city_id) {
                    $objCity = $cityFactory->getById($experience->city_id);
                    $experience->city = $objCity->getName();
                } else {
                    $experience->city = null;
                }
                if ($experience->postcode_id) {
                    $objPostcode = $postalCodeFactory->getById($experience->postcode_id);
                    $experience->postcode = $objPostcode->getPostalCode();
                } else {
                    $experience->postcode = null;
                }
            }
            $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where(
                'candidate_id',
                $user->owner_id
            )->orderByDesc('id')->get();
            foreach ($data['candidateEducations'] as $education) {
                $education->country = getCountryName($education->country_id);
            }
            $data['degreeLevels'] = RequiredDegreeLevel::pluck('name', 'id');
        }
        if ($sectionName == 'career_informations') {
        }

        return view(
            "candidate.profile.$sectionName",
            compact(
                "jsonLanguages",
                'arrCandidateStatuses',
                'objLastActivity',
                'candidateBasicSkills',
                'candidateAdvancedSkills',
                'candidateDrivingLicences',
                'candidateSoftwareSkills',
                'candidateAbleToTravel',
                'candidateCircumstances',
                'candidateAbleToMove',
                'objCandidateExtraQualifications',
                'candidateExtraRequirements',
                'objCity',
                'objPostCode',
                'candidate',
                'user',
                'data',
                'countries',
                'states',
                'cities',
                'candidateSkills',
                'candidateLanguage',
                'candidateJobCategories',
                'candidateJobShifts',
                'candidateJobType'
            )
        );
    }

    /**
     * @return mixed
     * @throws Exception
     *
     */
    public function showFavouriteJobs()
    {
        return view('candidate.favourite_jobs.index');
    }

    /**
     * @param CandidateUpdateProfileRequest $request
     *
     * @return RedirectResponse|Redirector
     */
    public function updateProfile(CandidateUpdateProfileRequest $request)
    {
        $this->candidateRepository->updateProfile($request->all());

        $input = $request->all();
        if ($this->isCandidate()) {
            Flash::success(trans('messages.candidate.updated_successfully'));
            return redirect(route('candidate.profile'));
        } else {
            Flash::success(trans('messages.candidate.successfully_updated'));
            return redirect(route('candidates.edit', ['candidate' => $input['candidate_id']]));
        }
    }

    /**
     * @param CandidateUpdateGeneralInformationRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     *
     */
    public function updateGeneralInformation(CandidateUpdateGeneralInformationRequest $request)
    {
        $user = $this->candidateRepository->updateGeneralInformation($request->all());
        $user['candidateSkill'] = $user->candidateSkill()->pluck('name')->toArray();

        return $this->sendResponse($user, 'Candidate profile updated successfully.');
    }

    /**
     * @param CandidateUpdateOnlineProfileRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     *
     */
    public function updateOnlineProfile(CandidateUpdateOnlineProfileRequest $request)
    {
        $user = $this->candidateRepository->updateGeneralInformation($request->all());
        $user['onlineProfileLayout'] = view(
            'candidate.profile.career_informations.show_online_profile',
            compact('user')
        )->render();
        $user['editonlineProfileLayout'] = view(
            'candidate.profile.career_informations.edit_online_profile',
            compact('user')
        )->render();

        return $this->sendResponse($user, 'Candidate profile updated successfully.');
    }

    /**
     * @param Request $request
     * @param $candidate_id
     * @return void
     * @throws Exception
     */
    public function getAllCVData(Request $request, $candidate_id)
    {
        if ($this->isCandidate()) {
            $objCandidate = $this->getCandidate();
            $candidate_id = $objCandidate->getId();
        }
        $MediaFactory = new App\Models\Factories\MediaFactory();
        $objCandidate = (new App\Models\Factories\CandidateFactory())->getById($candidate_id);
        if ($request->ajax()) {
            $data = $MediaFactory->getCandidateAllFormatted(Candidate::class, $objCandidate);
            return DataTables::of($data)->make(true);
        }
    }

    /**
     * @param Request $request
     * @param $candidate_id
     * @return void
     * @throws Exception
     */
    public function getAllDocumentsData(Request $request, $candidate_id)
    {
        $MediaFactory = new App\Models\Factories\MediaFactory();
        $objCandidate = (new App\Models\Factories\CandidateFactory())->getById($candidate_id);
        if ($request->ajax()) {
            $data = $MediaFactory->getCandidateAllDocumentsFormatted(Candidate::class, $objCandidate);
            return DataTables::of($data)->make(true);
        }
    }

    /**
     * @return array|string
     * @throws \Throwable
     *
     */
    public function getCVTemplate($candidate_id = null)
    {
        $UserFactory = new UserFactory();
        $CandidateDataProvider = new App\DataProviders\CandidateDataProvider();

        if (empty($candidate_id)) {
            $user = Auth::user();
        } else {
            $candidate = (new CandidateFactory())->getById($candidate_id);
            $user = $UserFactory->getById($candidate->user_id);
        }

        $data = $CandidateDataProvider->getCandidateData($user);
        return view(
            'candidate.profile.cv_template',
        )->with($data)->render();
    }

    public function previewCV($candidate_id = null)
    {
        $UserFactory = new UserFactory();
        $CandidateDataProvider = new App\DataProviders\CandidateDataProvider();

        if (empty($candidate_id)) {
            $user = Auth::user();
        } else {
            $candidate = (new CandidateFactory())->getById($candidate_id);
            $user = $UserFactory->getById($candidate->user_id);
        }

        $data = $CandidateDataProvider->getCandidateData($user);
        $html = view(
            'candidate.profile.cv_templete_generate',
        )->with($data)->render();
        $domPdf = new Dompdf([
            'isPhpEnabled' => true,
            'DOMPDF_ENABLE_CSS_FLOAT' => true,
        ]);
        $domPdf->setPaper('A4');

        $domPdf->loadHtml($html);
        $domPdf->render();


        return new Response($domPdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . 'cv_preview.pdf' . '"',
        ]);
    }

    /**
     * @param Request $request
     * @return MediaStream
     */
    public function generateCVBulk(Request $request)
    {
        $CandidateDataProvider = new App\DataProviders\CandidateDataProvider();
        $input = $request->all();
        $arrCandidates = $input["candidates"];
        $downloads = [];
        foreach ($arrCandidates as $candidate_id) {
            $objCandidate = (new App\Models\Factories\CandidateFactory())->getById($candidate_id);
            $user = (new App\Models\Factories\UserFactory())->getById($objCandidate->user_id);

            $filename = "cv_" . $user->getFirstName() . "_" . $user->getLastName() . "-" . date("Y_m_d") . "_" . rand(
                    10000,
                    99999
                ) . ".pdf";
            $full_path = storage_path() . "/app/resumes/" . $filename;


            $data = $CandidateDataProvider->getCandidateData($user);
            $html = view('candidate.profile.cv_templete_generate')
                ->with($data)
                ->render();

            try {
                $domPdf = new Dompdf([
                    'isPhpEnabled' => true,
                ]);

                $domPdf->loadHtml($html);
                $domPdf->render();
                $output = $domPdf->output();
                file_put_contents($full_path, $output);
            } catch (Exception $e) {
                return $this->sendError(
                    "Nem sikerült az önéletrajz készítése:(" . $full_path . ") -> " . $e->getMessage()
                );
            }

            if (!is_readable($full_path)) {
                return $this->sendError("Nem sikerült az önéletrajz felolvasása");
            }

            $media = $objCandidate->addMedia($full_path)
                ->withCustomProperties([
                                           'active' => true,
                                           'language' => App\Models\Language::LANG_HUNGARIAN,
                                           'title' => $filename,
                                       ])
                ->usingFileName($filename)
                ->toMediaCollection(
                    Candidate::RESUME_PATH,
                    config('app.media_disc')
                );
            $downloads[] = $media;
        }

        return MediaStream::create('my-files.zip')->addMedia($downloads);
    }

    /**
     * @param $candidate_id
     * @return mixed
     */
    public function generateCV($candidate_id)
    {
        if ($this->isCandidate()) {
            $objCandidate = $this->getCandidate();
            $candidate_id = $objCandidate->getId();
        }

        ini_set('pcre.backtrack_limit', 100000000);
        $CandidateDataProvider = new App\DataProviders\CandidateDataProvider();
        if (empty($candidate_id)) {
            $user = Auth::user();
        } else {
            $objCandidate = (new App\Models\Factories\CandidateFactory())->getById($candidate_id);
            $user = (new App\Models\Factories\UserFactory())->getById($objCandidate->user_id);
        }


        $objCandidate = (new App\Models\Factories\CandidateFactory())->getByUser($user);
        if (empty($objCandidate->postcode_id)) {
            return $this->sendError("Kérjük töltse ki az profil adatokat az önéletrajz generáláshoz");
        }

        $filename = "cv_" . $user->getFirstName() . "_" . $user->getLastName() . "-" . date("Y_m_d") . "_" . rand(
                10000,
                99999
            ) . ".pdf";
        $full_path = storage_path() . "/app/resumes/" . $filename;

        $data = $CandidateDataProvider->getCandidateData($user);

        $html = view('candidate.profile.cv_templete_generate')
            ->with($data)
            ->render();

        try {
            $domPdf = new Dompdf([
                'isPhpEnabled' => true,
            ]);

            $domPdf->loadHtml($html);
            $domPdf->render();
            $output = $domPdf->output();
            file_put_contents($full_path, $output);
        } catch (Exception $e) {
            return $this->sendError("Nem sikerült az önéletrajz készítése:(" . $full_path . ") -> " . $e->getMessage());
        }

        if (!is_readable($full_path)) {
            return $this->sendError("Nem sikerült az önéletrajz felolvasása");
        }

        $media = $objCandidate->addMedia($full_path)
            ->withCustomProperties([
                                       'active' => true,
                                       'language' => App\Models\Language::LANG_HUNGARIAN,
                                       'title' => $filename,
                                   ])
            ->usingFileName($filename)
            ->toMediaCollection(
                Candidate::RESUME_PATH,
                config('app.media_disc')
            );

        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$media->id])
            ->log('Munkavállaló önéletrajz generálás adatoktból')
            ->causer($causer);

        return $this->sendResponse(["result" => true], 'Candidate profile updated successfully.');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadResume(Request $request)
    {
        $input = $request->all();

        $candidate_id = $input["candidate_id"];
        if ($this->isCandidate()) {
            $objCandidate = $this->getCandidate();
            $input["candidate_id"] = $objCandidate->getId();
        }

        $objCandidate = (new CandidateFactory())->getById($input["candidate_id"]);
        $media = $this->candidateRepository->uploadResume($input);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$media->id])
            ->log('Munkavállalói önéletrajz feltöltés')
            ->causer($causer);
        return $this->sendSuccess(trans('messages.candidate_profile.cv_uploaded_successfully'));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function uploadDocuments(Request $request)
    {
        $input = $request->all();

        $objCandidate = (new CandidateFactory())->getById($input["candidate_id"]);
        $media = $this->candidateRepository->uploadDocument($input);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$media->id])
            ->log('Munkavállalói dokumentum feltöltés')
            ->causer($causer);
        return $this->sendSuccess(trans('messages.candidate_profile.document_uploaded_successfully'));
    }

    /**
     * @param int $media_id
     * @param int $change_to_value
     * @return mixed
     */
    public function resumeStatusToggle(int $media_id, int $change_to_value)
    {
        try {
            $MediaFactory = new App\Models\Factories\MediaFactory();
            $objMedia = $MediaFactory->getById($media_id);

            if ($this->isCandidate()) {
                $objCandidate = $this->getCandidate();
                $candidate_id = $objCandidate->getId();
                if ($objMedia->model_id !== $candidate_id) {
                    die('Nem endedélyezett művelet');
                }
            }

            $objCandidate = (new CandidateFactory())->getById($objMedia->model_id);

            if ($change_to_value == 0) {
                $numberOfActiveCV = $MediaFactory->findActiveCandidateCVs($objMedia, $objCandidate);
                if ($numberOfActiveCV === 0) {
                    return $this->sendError(
                        'Legalább egy aktív önéletrajznak kell lennie a munkavállalóhoz. A kiválasztott önéletrajz nem inaktiválható mert csak az az egy aktív jelenleg.'
                    );
                }
            }


            if (!$objMedia) {
                return $this->sendError("CV nem található", 404);
            }
            $objMedia = $MediaFactory->changeToValue($objMedia, $change_to_value);
            if (!$objMedia) {
                throw new Exception("CV nem státusz módosítás sikertelen");
            }

            if ($change_to_value == 1) {
                $log_text = "Munkavállalói önéletrajz státusz aktiválás";
            } else {
                $log_text = "Munkavállalói önéletrajz státusz inaktiválás";
            }

            $causer = \Illuminate\Support\Facades\Auth::user();
            activity()
                ->inLog("custom")
                ->inLog("custom")
                ->performedOn($objCandidate)
                ->withProperties([$objMedia->id])
                ->log($log_text)
                ->causer($causer);
        } catch (Exception $e) {
            return $this->sendError("CV nem státusz módosítás sikertelen", 500);
        }

        return $this->sendResponse(["result" => true], 'sikeres státusz változtatás.');
    }

    /**
     * @param int $media
     *
     * @return Media
     */
    public function downloadResume($media)
    {
        /** @var Media $mediaItem */
        $mediaItem = Media::findOrFail($media);

        return $mediaItem;
    }

    /**
     * @return mixed
     * @throws Exception
     *
     */
    public function showFavouriteCompanies()
    {
        return view('candidate.favourite_companies.index');
    }

    /**
     * @return Factory|View
     */
    public function editJobAlert()
    {
        $data = $this->candidateRepository->getJobAlerts();

        return view('candidate.job_alert.edit')->with($data);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function updateJobAlert(Request $request)
    {
        $this->candidateRepository->updateJobAlerts($request->all());
        Flash::success('Job Alert updated successfully.');

        return redirect(route('candidate.job.alert'));
    }

    /**
     * @param ChangePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $input = $request->all();

        try {
            $user = $this->candidateRepository->changePassword($input);

            return $this->sendSuccess('Password updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified User.
     *
     * @return JsonResponse
     */
    public function editCandidateProfile($candidate_id = null)
    {
        if (empty($candidate_id)) {
            $user_id = Auth::id();
        } else {
            $objCandidate = (new App\Models\Factories\CandidateFactory())->getById($candidate_id);
            $user_id = $objCandidate->user_id;
        }

        $user = User::with('candidate')->where('id', '=', $user_id)->first();
        return $this->sendResponse($user, 'Candidate retrieved successfully.');
    }

    /**
     * @param UpdateCandidateProfileRequest $request
     *
     * @return JsonResponse
     */
    public function profileUpdate(UpdateCandidateProfileRequest $request)
    {
        $input = $request->all();

        try {
            $employer = $this->candidateRepository->profileUpdate($input);
            Flash::success(trans('messages.candidate.successfully_saved'));

            return $this->sendResponse($employer, trans('messages.candidate.successfully_saved'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * @return mixed
     * @throws Exception
     *
     */
    public function showCandidateAppliedJob()
    {
        return view('candidate.applied_job.index');
    }

    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     *
     */
    public function getCandidateApplicationData(Request $request, $candidate_id)
    {
        $CandidateApplicationFactory = new App\Models\Factories\CandidateApplicationFactory();
        $CandidateFactory = new CandidateFactory();
        $objCandidate = $CandidateFactory->getById($candidate_id);

        $data = $CandidateApplicationFactory->getApplicationsByCandidate($objCandidate);

        return DataTables::of($data)->make(true);
    }


    /**
     * @return void
     */
    public function deleteProfile()
    {
        if (!$this->isCandidate()) {
            die("");
        }

        $objCandidate = $this->getCandidate();
        $objUser = (new UserFactory())->getById($objCandidate->user_id);

        $arrData = [
            "first_name" => $objUser->first_name,
            "last_name" => $objUser->last_name,
            "user_id" => $objUser->id,
            'delete_profile_url' => route('delete-profile-validated', ['user_id'=>$objUser->id,'token' => base64_encode($objUser->password)])
        ];

        Mailer::send($objUser, EmailTemplate::Candidate_Delete_Verified, $arrData);
        return $this->sendSuccess('Küldtünk Önnek egy email-t. Kövesse az emailben foglaltakat a profilja törléséhez.');
    }

    /**
     * @param $user_id
     * @param $token
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function deleteProfileValidated($user_id, $token)
    {


        $authUser  = \Illuminate\Support\Facades\Auth::user();
        if($authUser){
            \Illuminate\Support\Facades\Auth::logout();
        }

        $success = 0;
        $objUser = (new UserFactory())->getUserByIdAndToken($user_id, $token);

        if ($objUser) {

            $objUser->is_active = 0;
            if($objUser->save()) {
                $success = 1;
                activity()
                    ->inLog("custom")
                    ->performedOn($objUser)
                    ->log("Munkavállalói profil törlés")
                    ->causer($objUser);
            }
        }


        return view(
            "web.auth.deleted",
            compact(
                "success",
            )
        );
    }

    /**
     * @param Media $media
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function deletedResume(Media $media)
    {
        if ($this->isCandidate()) {
            $objCandidate = $this->getCandidate();
            $candidate_id = $objCandidate->getId();
            if ($media->model_id !== $candidate_id) {
                return $this->sendError(
                    'Nem endedélyezett művelet'
                );
            }
        }

        $MediaFactory = new App\Models\Factories\MediaFactory();
        $candidateFactory = new CandidateFactory();
        $objCandidate = $candidateFactory->getById($media->model_id);
        $numberOfActiveCV = $MediaFactory->findActiveCandidateCVs($media, $objCandidate);

        if ($numberOfActiveCV === 0) {
            return $this->sendError(
                'Legalább egy aktív önéletrajznak kell lennie a munkavállalóhoz. A kiválasztott önéletrajz nem törölhető mert csak az az egy aktív jelenleg.'
            );
        }

        $media->delete();

        $causer = \Illuminate\Support\Facades\Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$media->id])
            ->log("Munkavállalói önéletrajz törlés")
            ->causer($causer);

        return $this->sendSuccess('Media deleted successfully.');
    }

    /**
     * @param Media $media
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function deletedDocument(Media $media)
    {
        $candidateFactory = new CandidateFactory();
        $objCandidate = $candidateFactory->getById($media->model_id);
        $media->delete();

        $causer = \Illuminate\Support\Facades\Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$media->id])
            ->log("Munkavállalói documentum törlés")
            ->causer($causer);

        return $this->sendSuccess('Media document deleted successfully.');
    }

    /**
     * @param JobApplication $jobApplication
     *
     * @return mixed
     */
    public function showAppliedJobs(JobApplication $jobApplication)
    {
        return $this->sendResponse($jobApplication, 'Retrieved successfully.');
    }

    /**
     * @param JobApplication $jobApplication
     *
     * @return JsonResponse
     */
    public function showScheduleSlotBook(JobApplication $jobApplication)
    {
        /** @var JobApplicationSchedule $jobApplicationSchedules */
        $jobApplicationSchedules = JobApplicationSchedule::with([
                                                                    'jobApplication.job.company' => function ($query) {
                                                                        $query->without(
                                                                            'job.company.user.city',
                                                                            'job.company.user.state',
                                                                            'job.company.user.country',
                                                                            'job.company.user.media'
                                                                        );
                                                                    }
                                                                ])->whereJobApplicationId($jobApplication->id);


        /** @var JobApplication $job */
        $job = JobApplication::with([
                                        'candidate.user' => function ($query) {
                                            $query->without('user.media', 'user.city', 'user.state', 'user.country');
                                        }
                                    ], 'jobStage.company.user')->without('job')->whereId($jobApplication->id)->first();

        $data = [];

        foreach ($jobApplicationSchedules->get() as $jobApplicationSchedule) {
            $data[] = array(
                'notes' => !empty($jobApplicationSchedule->notes) ? $jobApplicationSchedule->notes : __(
                    'messages.job_stage.new_slot_send'
                ),
                'company_name' => $jobApplicationSchedule->jobApplication->job->company->user->full_name,
                'schedule_created_at' => Carbon::parse($jobApplicationSchedule->created_at)->format('jS M Y, h:m A'),
            );
        }
        $lastRecord = $jobApplicationSchedules->latest()->first();
        $data['rejectedSlot'] = $lastRecord->status == JobApplicationSchedule::STATUS_REJECTED;

        $allJobSchedule = JobApplicationSchedule::whereJobApplicationId($jobApplication->id)
            ->where('batch', $lastRecord->batch)
            ->where('stage_id', $lastRecord->stage_id)
            ->get();

        if (!($allJobSchedule->whereIn('status', JobApplicationSchedule::STATUS_SEND)->count() > 0)) {
            foreach ($allJobSchedule as $jobApplicationSchedule) {
                if ($jobApplicationSchedule->status == JobApplicationSchedule::STATUS_NOT_SEND) {
                    $data[] = array(
                        'notes' => !empty($jobApplicationSchedule->notes) ? $jobApplicationSchedule->notes : __(
                            'messages.job_stage.new_slot_send'
                        ),
                        'schedule_date' => Carbon::parse($jobApplicationSchedule->date)->format('jS M Y'),
                        'schedule_time' => $jobApplicationSchedule->time,
                        'job_Schedule_Id' => $jobApplicationSchedule->id,
                        'isAllRejected' => $jobApplicationSchedule->status == JobApplicationSchedule::STATUS_REJECTED,
                    );
                }
            }
        }
        $data['selectSlot'] = $allJobSchedule->whereIn('status', JobApplicationSchedule::STATUS_SEND)->toArray();
        $employerCancelNote = $allJobSchedule->where('employer_cancel_slot_notes')->first();
        $data['employer_cancel_note'] = isset($employerCancelNote) ? $employerCancelNote->employer_cancel_slot_notes : '';
        $data['employer_fullName'] = $job->candidate->user->full_name;;
        $data['company_fullName'] = $job->jobStage->company->user->full_name;
        $data['isSlotRejected'] = $jobApplicationSchedules->where(
            'status',
            JobApplicationSchedule::STATUS_REJECTED
        )->count();
        $data['scheduleSelect'] = $allJobSchedule->where('status', JobApplicationSchedule::STATUS_SEND)->count();

        return $this->sendResponse($data, 'job schedule send successfully');
    }

    /**
     * @param JobApplication $jobApplication
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function choosePreference(JobApplication $jobApplication, Request $request)
    {
        if (!isset($request->rejectSlot)) {
            $request->validate([
                                   'slot_book' => 'required',
                               ], [
                                   'slot_book.required' => 'Slot Preference Field is required'
                               ]);
        }

        $request->validate([
                               'choose_slot_notes' => 'required',
                           ], [
                               'choose_slot_notes.required' => 'Notes Field is required'
                           ]);
        $scheduleId = $request->get('schedule_id');
        $slotNotes = $request->get('choose_slot_notes');
        if (!isset($request->rejectSlot)) {
            JobApplicationSchedule::whereId($scheduleId)->update(
                ['status' => JobApplicationSchedule::STATUS_SEND, 'rejected_slot_notes' => $slotNotes]
            );
        } else {
            $jobApplicationSchedules = JobApplicationSchedule::whereJobApplicationId($jobApplication->id);
            $lastRecord = $jobApplicationSchedules->latest()->first();
            JobApplicationSchedule::where([
                                              ['job_application_id', $jobApplication->id],
                                              ['stage_id', $lastRecord->stage_id],
                                              ['batch', $lastRecord->batch],
                                              ['status', JobApplicationSchedule::STATUS_NOT_SEND]
                                          ])->update([
                                                         'status' => JobApplicationSchedule::STATUS_REJECTED,
                                                         'rejected_slot_notes' => $slotNotes
                                                     ]);
        }

        if (isset($request->rejectSlot)) {
            return $this->sendSuccess('Slots rejected successfully');
        }

        return $this->sendSuccess('Slot choose successfully');
    }

    /**
     * @param CandidateBatchStatusUpdate $request
     * @return void
     */
    public function batchStatusUpdate(CandidateBatchStatusUpdate $request)
    {
        try {
            $post = $request->post();
            $candidateFactory = new CandidateFactory();
            foreach ($post['candidates'] as $candidateId) {
                $objCandidate = $candidateFactory->getById($candidateId);
                $candidateFactory->changeStatus(
                    $objCandidate,
                    (new CandidateStatusFactory())->getById($post['status'])
                );
            }
        } catch (Exception $e) {
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }
        $this->ajaxresponse('success', '', []);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getCandidateCvs(Request $request)
    {
        try {
            $post = $request->post();
            $candidateFactory = new CandidateFactory();
            $objCandidate = $candidateFactory->getById($post['candidate']);
            if (!$objCandidate) {
                $this->ajaxresponse('error', trans('messages.common.process_failed'), []);
            }
            $this->ajaxresponse('success', '', ['resumes' => $objCandidate->getMedia('resumes')]);
        } catch (Exception $e) {
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }
    }
}
