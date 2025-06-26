<?php

namespace App\Http\Controllers\Web;

use App\Helpers\JobHelper;
use App\Helpers\Layout;
use App\Http\Controllers\AppBaseController;
use App\Http\Livewire\JobCategories;
use App\Http\Requests\EmailJobToFriendRequest;
use App\Models\City;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\JobFactory;
use App\Models\Factories\UserFactory;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\JobType;
use App\Repositories\JobRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Share;

class JobController extends AppBaseController
{
    /** @var JobRepository */
    private $jobRepository;

    public function __construct(JobRepository $jobRepo)
    {
        $this->jobRepository = $jobRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $data = $this->jobRepository->prepareJobData();
        $data['input'] = $request->all();

        return view('web.jobs.index')->with($data);
    }

    public function getRelevant(Request $request)
    {
        $params = [];
        $objCandidate = $this->getCandidate();
        if($objCandidate->travel_max_distance){

            $params["maxDistance"]=$objCandidate->travel_max_distance;
        }

        if($objCandidate->candidateJobCategories){
            $arrCategoryIds = [];
            foreach ($objCandidate->candidateJobCategories as $objobCategory){
                $arrCategoryIds[]=$objobCategory->id;
            }
            $strCategoryIds = implode(",",$arrCategoryIds);
            if($strCategoryIds){
                $params["categories"]=$strCategoryIds;
            }
        }
        return redirect(route("relevant_jobs",$params));
    }

    public function relevant(Request $request)
    {
        $data = $this->jobRepository->prepareJobData();
        $data['input'] = $request->all();
        $data['relevant'] = true;

        return view('web.jobs.index')->with($data);
    }
    /**
     * @param string $uniqueJobId
     *
     * @return Application|Factory|View
     */
    public function jobDetails(Request $request, string $uniqueJobId = null)
    {
        $job = null;

        $pageTitle =  trans('web.job_details.job_details');

        if ($uniqueJobId) {
            $job = Job::with('jobsTag')->whereJobId($uniqueJobId)->first();
            $fields = JobHelper::standardiseJobData($job);
            $objCompany = (new CompanyFactory())->getById($job->company_id);

            $fields['jobRequirements'] = $job->getJobRequirements();
            // check job status is active or not
            $data['isActive'] = $job->status == Job::STATUS_ACTIVE;

            if (in_array($job->status, Job::EDITABLE_STATUSES) && (Auth::guest() || Auth::user()->hasRole('Candidate'))) {
                abort(404);
            }

            if(in_array($job->status, Job::EDITABLE_STATUSES)){
                $pageTitle =  trans('web.job_details.job_preview');
            }



        } else {

            $fields = $request->post();

            $FormJob = (new JobFactory())->getById($fields["job_id"]);
            $objCompany = (new CompanyFactory())->getById($FormJob->company_id);

            $pageTitle =  trans('web.job_details.job_preview');

            $data['isActive'] = false;
            $fields['candidate_count'] = $fields['job_candidate_count'] ?? null;
            if (empty($fields['is_anonym'])) {
                $fields['is_anonym'] = false;
            }
            if (empty($fields['jobRequirements'])) {
                $fields['jobRequirements'] = null;
            }
            if (Auth::guest() || Auth::user()->hasRole('Candidate') || empty($fields['_token'] || $request->method() !== 'POST')) {
                abort(404);
            }

        }

        if ($uniqueJobId) {
            if (empty($job)) {
                Flash::error('Nem létező hirdetés');

                return redirect()->back();
            }
        }

        $company_id = null;

        if ($job) {
            $company_id = $job->company_id;
        } else {
            $company_id = \Illuminate\Support\Facades\Auth::user()->owner_id;
        }
        $companyFactory = new CompanyFactory();
        $userFactory = new UserFactory();

        $objCompany = $companyFactory->getById($company_id);

        if (!$objCompany) {
            abort(404);
        }
        $fields['company'] = $objCompany->toArray();

        $objUser = $userFactory->getById($objCompany->user_id);

        if (!$objUser) {
            abort(404);
        }
        $fields['companyUser'] = $objUser->toArray();

        $fields['companyCity'] = null;
        $fields['companyPostCode'] = null;

        if ($job) {
            if (in_array($job->status, Job::EDITABLE_STATUSES)) {
                if (!Auth::user()->hasRole('Admin')) {
                    if ($objUser->getId() != auth()->user()->id) {
                        abort(404);
                    }
                }
            }
        }
        if ($objCompany->city()->count()) {
            $fields['companyCity'] = $objCompany->city()->pluck('name');
        }
        if ($objCompany->postalCode()->count()) {
            $fields['companyPostCode'] = $objCompany->postalCode()->pluck('postal_code');
        }

        $data['resumes'] = null;

        $data['isActive'] = $data['isApplied'] = $data['isJobAddedToFavourite'] = $data['isJobReportedAsAbuse'] = false;
        if (Auth::check() && Auth::user()->hasRole('Candidate')) {
            $data = $this->jobRepository->getJobDetails($job);
        }
        $data['jobsCount'] = Job::whereStatus(Job::STATUS_ACTIVE)->whereCompanyId($company_id)->whereDate('job_expiry_date',
            '>=',
            Carbon::now()->toDateString())->count();


        $jobCategories = [];
        $jobTypes = [];
        $jobLocations = [];
        $jobShifts = [];
        $relatedJobs = [];
        $jobFactory = new JobFactory();

        if (!empty($fields['job_categories']) && !is_array($fields['job_categories'])) {
            $fields['job_categories'] = array($fields['job_categories']);
        }
        if (!empty($fields['job_types']) && !is_array($fields['job_types'])) {
            $fields['job_types'] = array($fields['job_types']);
        }
        if (!empty($fields['job_locations']) && !is_array($fields['job_locations'])) {
            $fields['job_locations'] = array($fields['job_locations']);
        }
        if (!empty($fields['job_shifts']) && !is_array($fields['job_shifts'])) {
            $fields['job_shifts'] = array($fields['job_shifts']);
        }

        if (!empty($fields['job_categories'])) {
            $relatedJobs = Job::query()->join('job_assigned_categories', 'job_assigned_categories.job_id', '=', 'jobs.id')
                ->whereIn('job_assigned_categories.job_category_id', $fields['job_categories'])
                ->where('status', '=', Job::STATUS_ACTIVE)
                ->whereDate('jobs.job_expiry_date', '>=', Carbon::now()->toDateString());
        }

        if ($uniqueJobId) {
            if ($relatedJobs) {
                $data['getRelatedJobs'] = $relatedJobs->whereNotIn('jobs.id', [$job->id])->orderByDesc('jobs.created_at')->take(5)->get();
            } else {
                $data['getRelatedJobs'] = [];
            }
        } else {
            if ($relatedJobs) {
                $data['getRelatedJobs'] = $relatedJobs->where('jobs.job_title', '!=', $fields['job_title'])->orderByDesc('jobs.created_at')->take(5)->get()->all();
            } else {
                $data['getRelatedJobs'] = [];
            }
        }

        if (!empty($fields['job_categories'])) {
            $jobCategories = JobCategory::query()->whereIn('id', $fields['job_categories'])->get()->all();
        }
        if (!empty($fields['job_types'])) {
            $jobTypes = JobType::query()->whereIn('id', $fields['job_types'])->get()->all();
        }
        if (!empty($fields['job_locations'])) {
            $jobLocations = City::query()->whereIn('id', $fields['job_locations'])->get()->all();
        }
        if (!empty($fields['job_shifts'])) {
            $jobShifts = JobShift::query()->whereIn('id', $fields['job_shifts'])->get()->all();
        }
        $url = [
            "gmail" => "https://plus.google.com/share?url=" . url()->current(),
            "twitter" => "https://twitter.com/intent/tweet?url=" . url()->current(),
            "facebook" => "https://www.facebook.com/sharer/sharer.php?u=" . url()->current(),
            "pinterest" => "http://pinterest.com/pin/create/button/?url=" . url()->current(),
        ];

        $requirementsHtml = !empty($fields['jobRequirements']) ? Layout::getJobRequirementFrontendHtml($fields['jobRequirements']) : '';


        return view('web.jobs.job_details', compact('pageTitle', 'requirementsHtml', 'job', 'objCompany', 'fields', 'jobCategories', 'jobTypes', 'jobLocations', 'jobShifts', 'url'))->with($data);

    }

    /**
     * @param  Request  $request
     *
     * @return JsonResource
     */
    public function saveFavouriteJob(Request $request)
    {
        $input = $request->all();
        $favouriteJob = $this->jobRepository->storeFavouriteJobs($input);
        if ($favouriteJob) {
            return $this->sendResponse($favouriteJob, 'Az állás kedvencek közzé el lett mentve.');
        }

        return $this->sendResponse($favouriteJob, 'Az állást eltávolítottuk a kedvencek közzül.');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResource
     */
    public function reportJobAbuse(Request $request)
    {
        $input = $request->all();
        $this->jobRepository->storeReportJobAbuse($input);

        return $this->sendSuccess('Job Abuse reported successfully.');
    }

    /**
     * @param  EmailJobToFriendRequest  $request
     *
     * @return JsonResource
     */
    public function emailJobToFriend(EmailJobToFriendRequest $request)
    {
        $input = $request->all();
        $this->jobRepository->emailJobToFriend($input);

        return $this->sendSuccess('Job Emailed to friend successfully.');
    }
}
