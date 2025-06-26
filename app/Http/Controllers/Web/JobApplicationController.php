<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Mailer;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\ApplyJobRequest;
use App\Mail\EmailToEmployer;
use App\Models\Candidate;
use App\Models\EmailTemplate;
use App\Models\Factories\UserFactory;
use App\Models\Job;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Repositories\JobApplicationRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class JobApplicationController extends AppBaseController
{
    /** @var JobApplicationRepository */
    private $jobApplicationRepository;

    public function __construct(JobApplicationRepository $jobApplicationRepo)
    {
        $this->jobApplicationRepository = $jobApplicationRepo;
    }

    /**
     * @param  string  $jobId
     *
     * @return Factory|View
     */
    public function showApplyJobForm($jobId)
    {
        $data = $this->jobApplicationRepository->showApplyJobForm($jobId);

        if (count($data['resumes']) <= 0) {
            return redirect()->back()->with('warning', 'There are no resume uploaded.');
        }

        return view('web.jobs.apply_job.apply_job')->with($data);
    }

    /**
     * @param  ApplyJobRequest  $request
     *
     * @return mixed
     */
    public function applyJob(ApplyJobRequest $request)
    {
        $input = $request->all();

        $this->jobApplicationRepository->store($input);

        /** @var Job $job */
        $job = Job::with(['company.user', 'appliedJobs'])->findOrFail($input['job_id']);
        $employerId = $job->company->user->id;

        $input['application_type'] != 'draft' ? NotificationSetting::whereKey(Notification::JOB_APPLICATION_SUBMITTED)->first()->value == 1 ?
            addNotification([
                Notification::JOB_APPLICATION_SUBMITTED,
                $employerId,
                Notification::EMPLOYER,
                trans('messages.apply_job.new_application_for').' '.$job->job_title,
            ]) : false : false;

        $activity_log_text = "Jelentkezés hirdetése";
        $causer = Auth::user();

        activity()
            ->inLog("custom")
            ->performedOn($job)
            ->log($activity_log_text)
            ->causer($causer);

        $userFactory = new UserFactory();

        $objCandidate = $userFactory->getById(getLoggedInUserId());
        $objEmployer = $userFactory->getById($job->company->user_id);

        $arrData = [
            "first_name" => $objCandidate->first_name,
            "position" => $job->position,
            'job_id' => $job->job_id,
            'company_profile_url' => route('front.company.details', ['uniqueId' => $job->company->unique_id]),
            'company_name'  => $job->company->name,
            'job_url'   => route('front.job.details', ['uniqueId' => $job->job_id]),
        ];

        Mailer::send($objCandidate, EmailTemplate::Job_Application_Candidate, $arrData);

        $arrData = [
            "first_name" => $objEmployer->first_name,
            "position" => $job->position,
            'job_id' => $job->job_id,
            'company_profile_url' => route('front.company.details', ['uniqueId' => $job->company->unique_id]),
            'company_name'  => $job->company->name,
            'job_url'   => route('front.job.details', ['uniqueId' => $job->job_id]),
        ];

        Mailer::send($objEmployer, EmailTemplate::Job_Application_Employer, $arrData);

        return $input['application_type'] == 'draft' ?
            $this->sendResponse($job->job_id, 'Job Application Drafted Successfully') :
            $this->sendResponse($job->job_id, trans('messages.apply_job.application_successful'));
    }
}
