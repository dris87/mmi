<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\JobHelper;
use App\Helpers\Mailer;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\JobBatchUpdateStatus;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\EmailTemplate;
use App\Models\Factories\CandidateApplicationFactory;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\JobApplicationFactory;
use App\Models\Factories\JobApplicationResumeFactory;
use App\Models\Factories\JobChangeFactory;
use App\Models\Factories\JobFactory;
use App\Models\Factories\UserFactory;
use App\Models\FeaturedRecord;
use App\Models\FrontSetting;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\ReportedJob;
use App\Models\State;
use App\Models\Transaction;
use App\Queries\JobDataTable;
use App\Queries\JobExpiredDataTable;
use App\Repositories\CompanyRepository;
use App\Repositories\JobRepository;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends AppBaseController
{
    /** @var JobRepository */
    private $jobRepository;

    public function __construct(JobRepository $jobRepo, CompanyRepository $companyRepo)
    {
        $this->jobRepository = $jobRepo;
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the Job.
     *
     * @throws \Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return \DataTables::of((new JobDataTable())->get($request->only(['is_featured', 'status'])))->make(true);
        }
        $statusArray = Job::STATUS;
        if (!$this->checkJobLimit()) {
            \Flash::error('Job create limit exceeded of your account, Update your subscription plan.');
        }
        $isFeaturedEnable = FrontSetting::where('key', 'featured_jobs_enable')->first();
        $isFeaturedEnable = ($isFeaturedEnable) ? $isFeaturedEnable->value : 0;

        $maxFeaturedJob = FrontSetting::where('key', 'featured_jobs_quota')->first()->value;
        $totalFeaturedJob = Job::Has('activeFeatured')->count();
        $isFeaturedAvilabal = ($totalFeaturedJob >= $maxFeaturedJob) ? false : true;
        $featured = Job::IS_FEATURED;

        return view(
            'employer.jobs.index',
            compact('statusArray', 'isFeaturedEnable', 'isFeaturedAvilabal', 'featured')
        );
    }

    /**
     * Show the form for creating a new Job.
     *
     * @return Factory|View
     */
    public function create()
    {
        $data = $this->jobRepository->prepareData();

        // Inicializáljuk a $fields tömböt az alapértelmezett értékekkel
        $fields = [
            'job_title' => '',
            'description' => '',
            'tasks' => '',
            'perks' => '',
            'advantages' => '',
            'job_position' => '',
            'job_candidate_count' => 1,
            'job_categories' => [],
            'job_types' => [],
            'job_locations' => [],
            'job_shifts' => [],
            'job_expiry_date' => Carbon::now()->addMonth()->format('Y-m-d'),
            'job_release_date' => Carbon::now()->format('Y-m-d'),
            'is_anonym' => 0,
            'jobRequirements' => [
                'education' => [],
                'experience' => [],
                'drivers_license' => [],
                'it_skill' => [],
                'software_skill' => [],
                'language_skill' => [],
                'personal_skill' => [],
            ],
        ];

        return view('employer.jobs.create', compact('data', 'fields'));
    }

    /**
     * Store a newly created Job in storage.
     *
     * @throws \Throwable
     *
     * @return Redirector|RedirectResponse
     */
    public function store(CreateJobRequest $request)
    {
        $input = $request->all();

        $input['status'] = (isset($request->saveDraft)) ? Job::STATUS_DRAFT : Job::STATUS_PENDING;
        $input['is_anonym'] = (isset($request->is_anonym)) ? 1 : 0;

        if (Job::STATUS_PENDING === $input['status']) {
            if (!$this->checkJobLimit()) {
                return redirect()->back()->withInput()->withErrors(['error' => trans('messages.job.limit_exceeded')]);
            }
        }

        $job = $this->jobRepository->store($input);

        activity()
            ->inLog('custom')
            ->performedOn($job)
            ->log('Hirdetés beküldése jóváhagyásra')
            ->causer(Auth::user())
        ;

        \Flash::success(trans('messages.job.saved'));

        return redirect(route('job.index'));
    }

    /**
     * @throws \Throwable
     */
    public function saveDraft(Request $request): void
    {
        $input = $request->all();

        $input['status'] = Job::STATUS_DRAFT;
        $input['is_anonym'] = (isset($request->is_anonym)) ? 1 : 0;

        $jobFactory = new JobFactory();
        $companyFactory = new CompanyFactory();
        $userFactory = new UserFactory();

        $objUser = $userFactory->getById(Auth::user()->id);
        $objJob = null;

        try {
            if (isset($input['job_id']) && !empty($input['job_id'])) {
                $objJob = $jobFactory->getById($input['job_id']);
                if ($objJob) {
                    /** @var Company $objCompany */
                    $objJobCompany = $companyFactory->getByJob($objJob);
                    $objUserCompany = $companyFactory->getByUser($objUser);
                    /* if(!Auth::user()->hasRole('Admin')) {
                         if($objUserCompany && $objJobCompany) {
                             if ($objJobCompany->first() !== $objUserCompany->first()) {
                                 $this->ajaxresponse('error', 'Invalid request, the editor doesnt belong to the owner of this job or the job doesnt exist', ['token' => csrf_token()]);
                             }
                         }
                         else{
                             $this->ajaxresponse('error', 'Invalid request, the editor doesnt belong to the owner of this job or the job doesnt exist', ['token' => csrf_token()]);
                         }
                     }*/
                } else {
                    $this->ajaxresponse(
                        'error',
                        'Invalid request, the editor doesnt belong to the owner of this job or the job doesnt exist',
                        ['token' => csrf_token()]
                    );
                }
            }
        } catch (\Exception $e) {
        }

        $objJob = $this->jobRepository->store($input, $objJob);

        if ($objJob) {
            activity()
                ->inLog('custom')
                ->performedOn($objJob)
                ->log('Hirdetés piszkozat mentés')
                ->causer(Auth::user())
            ;

            $this->ajaxresponse('success', 'Successfully saved the draft.', ['redirectTo' => route('job.index')]);
        }

        session()->regenerate();

        $this->ajaxresponse('error', 'There was an error saving the draft', ['token' => csrf_token()]);
    }

    /**
     * Update the specified Job in storage.
     *
     * @throws \Throwable
     *
     * @return Redirector|RedirectResponse
     */
    public function update(Job $job, UpdateJobRequest $request)
    {
        if (Job::STATUS_DRAFT !== $job->status) {
            if (!$this->checkJobLimit()) {
                return redirect()->back()->withInput()->withErrors(
                    ['error' => 'Job create limit exceeded of your account, Update your subscription plan.']
                );
            }
        }

        $input = $request->all();
        $input['is_anonym'] = (isset($input['is_anonym'])) ? 1 : 0;

        $input['status'] = $job->getStatus();

        if (Job::STATUS_APPROVED === $input['status'] || Job::STATUS_PENDING === $input['status']) {
            $input['status'] = Job::STATUS_PENDING;
            $objJobChange = $this->jobRepository->saveJobChange($job, $input);
            activity()
                ->inLog('custom')
                ->performedOn($job)
                ->log('Hirdetés módosítása beküldés után')
                ->causer(Auth::user())
            ;
            \Flash::success(trans('messages.job_crud.job_change_saved'));
        } else {
            $input['status'] = Job::STATUS_PENDING;
            $job = $this->jobRepository->store($input, $job);
            activity()
                ->inLog('custom')
                ->performedOn($job)
                ->log('Hirdetés beküldése jóváhagyásra')
                ->causer(Auth::user())
            ;
            \Flash::success(trans('messages.job_crud.job_updated'));
        }

        return redirect(route('job.index'));
    }

    /**
     * Update the specified Job in storage.
     *
     * @throws \Throwable
     *
     * @return Redirector|RedirectResponse
     */
    public function updateByAdmin(Job $job, UpdateJobRequest $request)
    {
        if (Job::STATUS_DRAFT !== $job->status) {
            if (!$this->checkJobLimit()) {
                return redirect()->back()->withInput()->withErrors(
                    ['error' => 'Job create limit exceeded of your account, Update your subscription plan.']
                );
            }
        }
        $input = $request->all();

        $input['status'] = $job->getStatus();
        $input['company_id'] = $job->getCompanyId();
        $input['is_anonym'] = (isset($input['is_anonym'])) ? 1 : 0;

        $job = $this->jobRepository->store($input, $job);
        activity()
            ->inLog('custom')
            ->performedOn($job)
            ->log('Hirdetés módosítása')
            ->causer(Auth::user())
        ;
        \Flash::success(trans('messages.job_crud.job_updated'));

        return redirect($input['redirect_url_after_update']);
    }

    /**
     * Display the specified Job.
     *
     * @return Factory|View
     */
    public function show(Job $job)
    {
        return view('employer.jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified Job.
     *
     * @return Factory|View
     */
    public function edit(Job $job)
    {
        $companyFactory = new CompanyFactory();
        $userFactory = new UserFactory();
        $objCompany = $companyFactory->getById($job->getCompanyId());
        $objUser = $userFactory->getById($objCompany->user_id);
        if ($objUser->id !== getLoggedInUserId()) {
            \Flash::error('Job Not Found.');

            return redirect(route('job.index'));
        }
        if (Job::STATUS_EXPIRED === $job->status || Job::STATUS_ACTIVE === $job->status) {
            return redirect(route('job.index'))->withErrors(trans('messages.job_errors.job_cant_be_edited'));
        }
        $data = $this->jobRepository->prepareData();
        $data['jobTags'] = [];
        $states = $cities = null;

        $jobChangeFactory = new JobChangeFactory();

        $objPendingJobChange = $jobChangeFactory->getPendingChangeByJob($job);

        if ($objPendingJobChange) {
            $fields = json_decode($objPendingJobChange->getFormData(), 1);
        } else {
            $fields = JobHelper::standardiseJobData($job);
        }

        if (isset($job->country_id)) {
            $states = getStates($job->country_id);
        }
        if (isset($job->state_id)) {
            $cities = getCities($job->state_id);
        }

        $draftStatusId = Job::STATUS_DRAFT;

        return view('employer.jobs.edit', compact('data', 'job', 'cities', 'states', 'fields', 'draftStatusId'));
    }

    /**
     * Remove the specified Job from storage.
     *
     * @throws \Exception
     *
     * @return Redirector|RedirectResponse
     */
    public function destroy(Job $job)
    {
        $jobAppliedCount = $job->appliedJobs()->whereIn(
            'status',
            [JobApplication::STATUS_APPLIED, JobApplication::STATUS_DRAFT]
        )->count();
        if ($jobAppliedCount > 0) {
            return $this->sendError('Job applied by candidate cannot be deleted.');
        }

        $this->jobRepository->delete($job->id);

        return $this->sendSuccess('Job deleted successfully.');
    }

    /**
     * @return mixed
     */
    public function getStates(Request $request)
    {
        $postal = $request->get('postal');

        $states = getStates($postal);

        return $this->sendResponse($states, 'Retrieved successfully');
    }

    /**
     * @return mixed
     */
    public function getCities(Request $request)
    {
        $state = $request->get('state');
        $cities = getCities($state);

        return $this->sendResponse($cities, 'Retrieved successfully');
    }

    /**
     * @throws \Exception
     *
     * @return Application|Factory|View
     */
    public function getJobs(Request $request)
    {
        $data = $this->companyRepository->get();
        $companyFactory = new CompanyFactory();

        if ($request->ajax()) {
            $data = $companyFactory->getAllFormatted();

            return \Yajra\DataTables\DataTables::of($data)->make(true);
        }

        return view('jobs.index', compact('data'));
    }

    /**
     * @param null|mixed $company_id
     *
     * @return mixed
     */
    public function getJobsData($company_id = null)
    {
        return \DataTables::of(
            (new JobDataTable())->getJobs($company_id)
        )->make(true);
    }

    public function activateJob(Request $request): void
    {
        $JobFactory = new JobFactory();
        $input = $request->all();

        if (!$this->isAdmin()) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $objJob = $JobFactory->getById($input['job_id']);
        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $objJob = $JobFactory->setStatusTo($objJob, Job::STATUS_ACTIVE);

        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $activity_log_text = 'Hirdetés aktiválása';
        $causer = Auth::user();
        activity()
            ->inLog('custom')
            ->performedOn($objJob)
            ->log($activity_log_text)
            ->causer($causer)
        ;

        $this->ajaxresponse('success', 'Sikeres aktiválás', []);
    }

    /**
     * @throws \Throwable
     */
    public function toggleApprove(Request $request): void
    {
        $JobFactory = new JobFactory();
        $input = $request->all();

        if (!$this->isAdmin()) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $objJob = $JobFactory->getById($input['job_id']);
        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $jobChangeFactory = new JobChangeFactory();
        $objJobChange = $jobChangeFactory->getPendingChangeByJob($objJob);

        if ($objJobChange) {
            $fields = json_decode($objJobChange->getFormData(), 1);
            $fields['company_id'] = $objJob->getCompanyId();
            $jobMerge = $this->jobRepository->store($fields, $objJob);

            if (!$jobMerge) {
                $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
            }

            $delete = $objJobChange->delete();
        }

        $input = $request->all();
        if (1 === (int) $input['status']) {
            $objJob = $JobFactory->setStatusTo($objJob, Job::STATUS_APPROVED);
            $activity_log_text = 'Hirdetés jóváhagyása';
        } else {
            $objJob = $JobFactory->setStatusTo($objJob, Job::STATUS_ADMIN_DECLINED);
            $activity_log_text = 'Hirdetés elutasítása';
        }

        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $causer = Auth::user();
        activity()
            ->inLog('custom')
            ->performedOn($objJob)
            ->log($activity_log_text)
            ->causer($causer)
        ;

        $this->ajaxresponse('success', 'Sikeres módosítás', []);
    }

    public function jobSendEmail(Request $request): void
    {
        try {
            $input = $request->all();
            $objJob = (new JobFactory())->getById($input['job_id']);
            $objCompany = (new CompanyFactory())->getById($objJob->getCompanyId());
            $objCompanyUser = $objCompany->user;

            $arrData = [
                'first_name' => $objCompanyUser->first_name,
                'position' => $objJob->position,
                'company_name' => $objCompany->name,
                'job_url' => route('front.job.details', ['uniqueId' => $objJob->job_id]),
            ];

            Mailer::send($objCompanyUser, EmailTemplate::Company_Company_Review, $arrData);
            $activity_log_text = 'Sikeres látványterv kiküldés';

            $causer = Auth::user();
            activity()
                ->inLog('custom')
                ->performedOn($objJob)
                ->log($activity_log_text)
                ->causer($causer)
            ;
        } catch (\Exception $e) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $this->ajaxresponse('success', $activity_log_text, []);
    }

    public function toggleStatus(Request $request): void
    {
        $JobFactory = new JobFactory();
        $input = $request->all();

        if (!$this->isAdmin()) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $objJob = $JobFactory->getById($input['job_id']);
        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $input = $request->all();
        if (1 === (int) $input['status']) {
            $objJob = $JobFactory->setSuspended($objJob, 1);
            $activity_log_text = 'Hirdetés felfüggesztése';
        } else {
            $objJob = $JobFactory->setSuspended($objJob, 0);
            $activity_log_text = 'Hirdetés felfüggesztésének feloldása';
        }

        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $causer = Auth::user();
        activity()
            ->inLog('custom')
            ->performedOn($objJob)
            ->log($activity_log_text)
            ->causer($causer)
        ;

        $this->ajaxresponse('success', 'Sikeres módosítás', ['title' => 'Siker', 'message' => 'Sikeres módosítás']);
    }

    public function appliedApplicants($job_id)
    {
        if (!$this->isAdmin()) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $CandidateApplicationFactory = new CandidateApplicationFactory();
        $JobFactory = new JobFactory();
        $objJob = $JobFactory->getById($job_id);

        if (!$objJob) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $arrApplications = $CandidateApplicationFactory->getCandidateByApplication($objJob);
        $html = view('jobs.job_applicants', ['arrApplications' => $arrApplications]);
        $html = str_replace("\n", '', $html);

        return $this->ajaxresponse('success', null, ['html' => $html]);
    }

    public function appliedApplicantResumes($job_application_id)
    {
        $JobFactory = new JobFactory();

        if (!$this->isAdmin()) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $objJobApplication = (new JobApplicationFactory())->getById($job_application_id);
        $objJob = $JobFactory->getById($objJobApplication->getJobId());

        if (!$objJobApplication) {
            $this->ajaxresponse('error', trans('messages.common.process_failed'), ['token' => csrf_token()]);
        }

        $arrApplicationResumes = (new JobApplicationResumeFactory())->getByJobApplication($objJobApplication);

        //        dump($objJob->job_title);
        //        dump($objJobApplication->candidate->user->first_name);
        //        dd($objJobApplication->candidate->user->last_name);

        $html = view('companies.profile.applied_resumes_list', [
            'objJob' => $objJob,
            'objJobApplication' => $objJobApplication,
            'arrApplicationResumes' => $arrApplicationResumes,
        ]);
        $html = str_replace("\n", '', $html);

        return $this->ajaxresponse('success', null, ['html' => $html]);
    }

    /**
     * @return Factory|View
     */
    public function createJob()
    {
        $data = $this->jobRepository->prepareData();
        $countries = Country::pluck('name', 'id');
        $states = State::toBase()->pluck('name', 'id');

        return view('jobs.create', compact('countries', 'states'))->with('data', $data);
    }

    /**
     * @throws \Throwable
     *
     * @return Redirector|RedirectResponse
     */
    public function storeJob(CreateJobRequest $request)
    {
        $input = $request->all();
        $input['is_anonym'] = (isset($request->is_anonym)) ? 1 : 0;
        $input['status'] = Job::STATUS_PENDING;

        $this->jobRepository->store($input);

        \Flash::success('Job saved successfully.');

        return redirect(route('admin.jobs.index'));
    }

    /**
     * Show the form for editing the specified Job.
     *
     * @return Factory|View
     */
    public function editJob(Job $job)
    {
        $companyFactory = new CompanyFactory();
        $userFactory = new UserFactory();
        $objCompany = $companyFactory->getById($job->getCompanyId());
        $objUser = $userFactory->getById($objCompany->user_id);
        //        if ($objUser->id !== getLoggedInUserId()) {
        //            Flash::error('Job Not Found.');
        //
        //            return redirect(route('job.index'));
        //        }
        //        if ($job->status == Job::STATUS_EXPIRED || $job->status == Job::STATUS_ACTIVE) {
        //            return redirect(route('job.index'))->withErrors(trans('messages.job_errors.job_cant_be_edited'));
        //        }
        $data = $this->jobRepository->prepareData();
        $data['jobTags'] = [];
        $states = $cities = null;

        $jobChangeFactory = new JobChangeFactory();

        $objPendingJobChange = $jobChangeFactory->getPendingChangeByJob($job);

        if ($objPendingJobChange) {
            $fields = json_decode($objPendingJobChange->getFormData(), 1);
        } else {
            $fields = JobHelper::standardiseJobData($job);
        }

        if (isset($job->country_id)) {
            $states = getStates($job->country_id);
        }
        if (isset($job->state_id)) {
            $cities = getCities($job->state_id);
        }

        $draftStatusId = Job::STATUS_DRAFT;

        //
        //        $data = $this->jobRepository->prepareData();
        //        $data['jobTags'] = $job->jobsTag()->pluck('tag_id')->toArray();
        //        $states = $cities = null;
        //        if (isset($job->country_id)) {
        //            $states = getStates($job->country_id);
        //        }
        //        if (isset($job->state_id)) {
        //            $cities = getCities($job->state_id);
        //        }

        $countries = Country::pluck('name', 'id');

        return view('jobs.edit', compact('data', 'job', 'cities', 'states', 'fields', 'draftStatusId'));
    }

    /**
     * Update the specified Job in storage.
     *
     * @throws \Throwable
     *
     * @return Redirector|RedirectResponse
     */
    public function updateJob(Job $job, UpdateJobRequest $request)
    {
        $input = $request->all();
        $input['is_anonym'] = (isset($input['is_anonym'])) ? 1 : 0;
        $input['status'] = Job::STATUS_PENDING;

        $this->jobRepository->store($input, $job);

        \Flash::success(trans('messages.job_crud.job_updated'));

        return redirect(route('admin.jobs.index'));
    }

    /**
     * Display the specified Job.
     *
     * @return Factory|View
     */
    public function showJobs(Job $job)
    {
        $job = Job::with('company.user')->whereId($job->id)->first();

        return view('jobs.show')->with('job', $job);
    }

    /**
     * Remove the specified Job from storage.
     *
     * @throws \Exception
     *
     * @return Redirector|RedirectResponse
     */
    public function delete(Job $job)
    {
        $jobAppliedCount = $job->appliedJobs()->where('status', JobApplication::STATUS_APPLIED)->count();
        if ($jobAppliedCount > 0) {
            return $this->sendError('Job applied by candidate cannot be deleted.');
        }

        $this->jobRepository->delete($job->id);

        return $this->sendSuccess('Job deleted successfully.');
    }

    /**
     * @return mixed
     */
    public function changeIsSuspended(Job $job)
    {
        $isSuspended = $job->is_suspended;
        $job->update(['is_suspended' => !$isSuspended]);

        return $this->sendSuccess('Status changed successfully.');
    }

    /**
     * @return Application|Factory|View
     */
    public function showReportedJobs(Request $request)
    {
        $reportedJob = ReportedJob::all();

        return view('employer.jobs.reported_jobs', compact('reportedJob'));
    }

    /**
     * @param mixed $id
     * @param mixed $status
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function changeJobStatus($id, $status)
    {
        /** @var Job $job */
        $job = Job::findOrFail($id);
        if (Job::STATUS_ACTIVE !== $job->status && Job::STATUS_ACTIVE === $status) {
            if (!$this->checkJobLimit()) {
                return $this->sendError('Job create limit exceeded of your account, Update your subscription plan.');
            }
        }

        $job->update(['status' => $status]);

        return $this->sendSuccess('Status changed successfully.');
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function deleteReportedJobs(ReportedJob $reportedJob)
    {
        $reportedJob->delete();

        return $this->sendSuccess('Reported Jobs deleted successfully.');
    }

    /**
     * @return mixed
     */
    public function showReportedJobNote(ReportedJob $reportedJob)
    {
        $data = $this->jobRepository->getReportedJobs($reportedJob->id);
        $data['date'] = Carbon::parse($data->created_at)->formatLocalized('%d %b, %Y');

        return $this->sendResponse($data, 'Retrieved successfully.');
    }

    /**
     * @throws \Exception
     *
     * @return bool|RedirectResponse
     */
    public function checkJobLimit()
    {
        //        $job = $this->jobRepository->canCreateMoreJobs();
        //
        //        if (! $job) {
        //            return false;
        //        }

        return true;
    }

    /**
     * @param mixed $jobId
     *
     * @return mixed
     */
    public function makeFeatured($jobId)
    {
        $user = getLoggedInUser();
        $addDays = FrontSetting::where('key', 'featured_jobs_days')->first()->value;
        $price = FrontSetting::where('key', 'featured_jobs_price')->first()->value;
        $maxFeaturedJob = FrontSetting::where('key', 'featured_jobs_quota')->first()->value;
        $totalFeaturedJob = Job::Has('activeFeatured')->count();
        $isFeaturedAvailable = ($totalFeaturedJob >= $maxFeaturedJob) ? false : true;
        $employerUser = Job::with('company.user')->findOrFail($jobId);

        if ($isFeaturedAvailable) {
            $featuredRecord = [
                'owner_id' => $jobId,
                'owner_type' => Job::class,
                'user_id' => $user->id,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays($addDays),
            ];
            FeaturedRecord::create($featuredRecord);
            1 === NotificationSetting::whereKey(Notification::MARK_JOB_FEATURED_ADMIN)->where(
                'type',
                'admin'
            )->first()->value
                ? addNotification([
                    Notification::MARK_JOB_FEATURED_ADMIN,
                    $employerUser->company->user->id,
                    Notification::EMPLOYER,
                    $user->first_name.' '.$user->last_name.' mark '.$employerUser->job_title.' as Featured.',
                ]) : false;
            $transaction = [
                'owner_id' => $jobId,
                'owner_type' => Job::class,
                'user_id' => $user->id,
                'amount' => $price,
            ];
            Transaction::create($transaction);

            return $this->sendSuccess('Job Make Featured successfully.');
        }

        return $this->sendError('Featured Quota is Not available.');
    }

    /**
     * @param mixed $jobId
     *
     * @return mixed
     */
    public function makeUnFeatured($jobId)
    {
        /** @var FeaturedRecord $unFeatured */
        $unFeatured = FeaturedRecord::where('owner_id', $jobId)->where('owner_type', Job::class)->first();
        $unFeatured->delete();

        return $this->sendSuccess('Job Make UnFeatured successfully.');
    }

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function getExpiredJobs(Request $request)
    {
        if ($request->ajax()) {
            return \DataTables::of((new JobExpiredDataTable())->getJobs())->make(true);
        }

        return view('job_expired.index');
    }

    public function batchStatusUpdate(JobBatchUpdateStatus $request): void
    {
        try {
            $post = $request->post();

            $jobStatuses = Job::STATUS;

            if (!isset($jobStatuses[$post['status']])) {
                throw new \Exception('Invalid job status');
            }
            $jobFactory = new JobFactory();
            foreach ($post['jobs'] as $jobId) {
                $objJob = $jobFactory->getById($jobId);

                if (!$objJob) {
                    throw new \Exception('Job not found');
                }

                /** @var Job $objJob */
                if (!$objJob->update(['status' => $post['status']])) {
                    throw new \Exception('Failed to update job status');
                }
            }
        } catch (\Exception $e) {
            $this->ajaxresponse('error', trans('messages.datatable.batch_process_failed'), []);
        }
        $this->ajaxresponse('success', '', []);
    }
}
