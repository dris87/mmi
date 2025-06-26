<?php

namespace App\Http\Controllers;

use App\Exports\CandidatesExport;
use App\Http\Livewire\Cities;
use App\Http\Requests\CandidateBatchStatusUpdate;
use App\Http\Requests\CreateCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\City;
use App\Models\Country;
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
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\JobType;
use App\Models\RequiredDegreeLevel;
use App\Models\SalaryCurrency;
use App\Models\Skill;
use App\Models\State;
use App\Queries\ReportedCandidateDataTable;
use App\Queries\ResumesDataTable;
use App\ReportedToCandidate;
use App\Repositories\Candidates\CandidateRepository;
use Carbon\Carbon;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\DataTables;

class CandidateController extends AppBaseController
{
    /** @var CandidateRepository */
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }

    /**
     * Display a listing of the Candidate.
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     * @throws Exception
     *
     */
    public function index(Request $request)
    {
        $statusArr = Candidate::STATUS;
        $immediateAvailable = Candidate::IMMEDIATE_AVAILABLE;
        $jobsSkills = Skill::toBase()->pluck('name', 'id')->toArray();
        $candidates = Candidate::all();
        $arrCandidateStatus = (new CandidateStatusFactory)->getAll();

        return view(
            'candidates.index',
            compact('arrCandidateStatus', 'statusArr', 'immediateAvailable', 'jobsSkills', 'candidates')
        );
    }

    public function getCandidateData(Request $request)
    {
        $candidateFactory = new CandidateFactory();
        $data = $candidateFactory->getAllFormatted();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new Candidate.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = $this->candidateRepository->prepareData();
        $countries = Country::pluck('name', 'id');
        $states = State::toBase()->pluck('name', 'id');

        return view('candidates.create', compact('data', 'countries', 'states'));
    }

    /**
     * Store a newly created Candidate in storage.
     *
     * @param CreateCandidateRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateCandidateRequest $request)
    {
        $input = $request->all();
        $candidate = $this->candidateRepository->store($input);

        if ($candidate) {
            Flash::success(trans('messages.candidate.successfully_saved'));
        } else {
            Flash::success(trans('messages.candidate.unsuccessfully_save'));
        }

        return redirect(route('candidates.edit', ['candidate' => $candidate->id]));
    }

    /**
     * Display the specified Candidate.
     *
     * @param Candidate $candidate
     *
     * @return Application|Factory|View
     */
    public function show(Candidate $candidate)
    {
        $currency = SalaryCurrency::pluck('currency_name', 'id');
        return view('candidates.show', compact('currency'))->with('candidate', $candidate);
    }


    /**
     * Show the form for editing the specified Candidate.
     *
     * @param Candidate $candidate
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function edit(Candidate $candidate, Request $request)
    {
        $LanguageFactory = new LanguageFactory();
        $CandidateStatusFactory = new CandidateStatusFactory();
        $UserFactory = new UserFactory();
        $CityFactory = new CityFactory();
        $PostalCodeFactory = new PostalCodeFactory();
        $arrCandidateStatuses = $CandidateStatusFactory->collectionToIndexedArray($CandidateStatusFactory->getAll());
        $user = $UserFactory->getById($candidate->user_id);
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
                $education->city = getCityName($education->city_id);
            }
            $data['degreeLevels'] = RequiredDegreeLevel::pluck('name', 'id');
        }
        if ($sectionName == 'career_informations') {
        }

        return view(
            "candidates.profile.$sectionName",
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
     * Update the specified Candidate in storage.
     *
     * @param Candidate $candidate
     * @param UpdateCandidateRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Candidate $candidate, UpdateCandidateRequest $request)
    {
        $input = $request->all();
        if (empty($candidate)) {
            Flash::success(trans('messages.candidate.not_found'));
            return redirect(route('candidates.index'));
        }
        $candidate = $this->candidateRepository->updateCandidate($candidate, $input);
        Flash::success(trans('messages.candidate.successfully_updated'));

        return redirect(route('candidates.index'));
    }

    /**
     * Remove the specified Candidate from storage.
     *
     * @param Candidate $candidate
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->user->delete();
        $candidate->delete();

        return $this->sendSuccess('Candidate deleted successfully.');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function changeStatus($id)
    {
        $candidate = Candidate::findOrFail($id);
        $status = !$candidate->user->is_active;
        $candidate->user->update(['is_active' => $status]);

        return $this->sendSuccess(trans('messages.common.status_updated'));
    }

    /**
     * @param Request $request
     *
     * @return JsonResource
     */
    public function reportCandidate(Request $request)
    {
        $input = $request->all();
        $this->candidateRepository->storeReportCandidate($input);

        return $this->sendSuccess('candidate Reported successfully.');
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     * @throws Exception
     *
     */
    public function showReportedCandidates(Request $request)
    {
        $reportedCandidate = ReportedToCandidate::all();

        return view('candidate.reported_candidate.reported_candidates', compact('reportedCandidate'));
    }

    /**
     * @param ReportedToCompany $reportedToCompany
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function showReportedCandiateNote(Request $request)
    {
        $data = $this->candidateRepository->getReportedToCandidate($request->reportedToCandidate);
        $data['date'] = \Carbon\Carbon::parse($data->created_at)->formatLocalized('%d %b, %Y');

        return $this->sendResponse($data, 'Retrieved successfully.');
    }

    /**
     * @param ReportedToCompany $reportedToCompany
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function deleteReportedCandidate(ReportedToCandidate $reportedToCandidate)
    {
        $reportedToCandidate->delete();

        return $this->sendSuccess('Reported Candidate deleted successfully.');
    }

    /**
     * @param Candidate $candidate
     *
     * @return mixed
     */
    public function changeIsEmailVerified(Candidate $candidate)
    {
        if (empty($candidate->user->email_verified_at)) {
            $candidate->user->update([
                                         'email_verified_at' => Carbon::now(),
                                         'is_verified' => 1,
                                     ]);
        } else {
            $candidate->user->update(['email_verified_at' => null]);
        }


        return $this->sendSuccess(trans('messages.common.email_verified_message'));
    }

    /**
     * @param Candidate $candidate
     *
     * @return mixed
     */
    public function resendEmailVerification(Candidate $candidate)
    {
        $candidate->user->sendEmailVerificationNotification();
        return $this->sendSuccess(trans('messages.common.verification_mail_resent'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function candidateExportExcel()
    {
        return Excel::download(new CandidatesExport(), 'candidates-' . time() . '.xlsx');
    }

    public function resumes(Request $request)
    {
        return view('resumes.index');
    }

    public function downloadResume($media)
    {
        $mediaItem = Media::findOrFail($media);

        if($this->isCandidate()){
            $objCandidate = $this->getCandidate();
            $candidate_id = $objCandidate->getId();
            if($mediaItem->model_id !== $candidate_id){
                die( 'Nem endedélyezett művelet');
            }
        }
        /** @var Media $mediaItem */
        $mediaItem = Media::findOrFail($media);

        return $mediaItem;
    }

    public function deleteResume(Media $media)
    {
        $media->delete();

        return $this->sendSuccess('Resume deleted successfully.');
    }
}
