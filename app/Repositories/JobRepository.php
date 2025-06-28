<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Mail\EmailJobToFriend;
use App\Mail\EmailToCandidate;
use App\Models\Candidate;
use App\Models\CareerLevel;
use App\Models\City;
use App\Models\Company;
use App\Models\DrivingLicences;
use App\Models\EmailJob;
use App\Models\EmailTemplate;
use App\Models\Factories\JobAssignedCategoryFactory;
use App\Models\Factories\JobAssignedShiftFactory;
use App\Models\Factories\JobAssignedTypeFactory;
use App\Models\Factories\JobChangeFactory;
use App\Models\Factories\JobDrivingLicenseFactory;
use App\Models\Factories\JobEducationFactory;
use App\Models\Factories\JobExperienceFactory;
use App\Models\Factories\JobItSkillFactory;
use App\Models\Factories\JobLanguageSkillFactory;
use App\Models\Factories\JobLocationFactory;
use App\Models\Factories\JobPersonalSkillFactory;
use App\Models\Factories\JobSoftwareSkillFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\FavouriteJob;
use App\Models\FrontSetting;
use App\Models\FunctionalArea;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobRequirementType;
use App\Models\JobShift;
use App\Models\JobType;
use App\Models\Language;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Plan;
use App\Models\ReportedJob;
use App\Models\RequiredDegreeLevel;
use App\Models\SalaryCurrency;
use App\Models\SalaryPeriod;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PragmaRX\Countries\Package\Countries;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobRepository.
 *
 * @version July 12, 2020, 12:34 pm UTC
 */
class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_title',
        'is_freelance',
        'hide_salary',
    ];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model.
     */
    public function model()
    {
        return Job::class;
    }

    /**
     * @return array
     */
    public function prepareJobData()
    {
        $data['jobCategories'] = JobCategory::toBase()->pluck('name', 'id');
        $data['jobSkills'] = Skill::toBase()->pluck('name', 'id');
        $data['careerLevels'] = CareerLevel::toBase()->pluck('level_name', 'id');
        $data['functionalAreas'] = FunctionalArea::toBase()->pluck('name', 'id');
        $data['advertise_image'] = FrontSetting::where('key', '=', 'advertise_image')->toBase()->first();
        $data['jobShifts'] = JobShift::toBase()->pluck('shift', 'id');
        $data['requiredDegreeLevels'] = RequiredDegreeLevel::toBase()->pluck('name', 'id');
        $data['drivingLicences'] = DrivingLicences::toBase()->pluck('name', 'id');
        $data['jobTypes'] = JobType::toBase()->pluck('name', 'id');
        $data['language'] = Language::toBase()->pluck('language', 'id');

        return $data;
    }

    /**
     * @return mixed
     */
    public function prepareData()
    {
        $countries = new Countries();
        $data['cities'] = City::toBase()->pluck('name', 'id');
        $data['jobType'] = JobType::pluck('name', 'id');
        $data['jobRequirementType'] = JobRequirementType::pluck('translation_key', 'id');
        $data['jobCategory'] = JobCategory::pluck('name', 'id');
        $data['careerLevels'] = CareerLevel::pluck('level_name', 'id');
        $data['jobShift'] = JobShift::pluck('shift', 'id');
        $data['currencies'] = SalaryCurrency::pluck('currency_name', 'id');
        $data['salaryPeriods'] = SalaryPeriod::pluck('period', 'id');
        $data['functionalArea'] = FunctionalArea::pluck('name', 'id');
        $data['jobSkill'] = Skill::pluck('name', 'id');
        $data['jobTag'] = Tag::pluck('name', 'id');
        $data['requiredDegreeLevel'] = RequiredDegreeLevel::pluck('name', 'id');
        $data['countries'] = getCountries();
        $data['companies'] = Company::with('user')->get()->pluck('user.full_name', 'id')->sort();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getUniqueJobId()
    {
        $jobUniqueId = Str::random(12);
        while (true) {
            $isExist = Job::whereJobId($jobUniqueId)->exists();
            if ($isExist) {
                self::getUniqueJobId();
            }

            break;
        }

        return $jobUniqueId;
    }

    public function saveJobChange(Job $job, array $formData)
    {
        \DB::beginTransaction();
        $jobChangeFactory = new JobChangeFactory();
        $objJobChange = $jobChangeFactory->getPendingChangeByJob($job);
        if ($objJobChange) {
            $jobChangeFactory->update($objJobChange, $formData);
        } else {
            $objJobChange = $jobChangeFactory->create($job, $formData);
        }

        \DB::commit();

        $job->update(['status' => Job::STATUS_PENDING]);

        return $objJobChange;
    }

    /**
     * @param array      $input
     * @param null|mixed $job
     *
     * @throws \Throwable
     *
     * @return Job|Model
     */
    public function store($input, $job = null)
    {
        try {
            \DB::beginTransaction();

            $input['company_id'] = (isset($input['company_id'])) ? $input['company_id'] : Auth::user()->owner_id;
            if ($job) {
                $input['job_id'] = $job->job_id;
            } else {
                $input['job_id'] = $this->getUniqueJobId();
            }
            if (empty($input['job_title'])) {
                $input['job_title'] = trans('messages.job.draft_title').' #'.$input['job_id'];
            }

            /** @var Job $job */
            if (Auth::user()->hasRole('Admin') && !$job) {
                $input['is_created_by_admin'] = 1;
            } else {
                $input['is_created_by_admin'] = 0;
            }

            $jobData = [
                'job_id' => $input['job_id'],
                'job_title' => $input['job_title'] ?? trans('messages.job.draft_title'),
                'description' => $input['description'] ?? '',
                'tasks' => $input['tasks'] ?? '',
                'perks' => $input['perks'] ?? '',
                'advantages' => $input['advantages'] ?? '',
                'position' => $input['job_position'] ?? $input['position'] ?? '',  // FONTOS: job_position -> position
                'candidate_count' => $input['job_candidate_count'] ?? $input['candidate_count'] ?? 1,  // FONTOS: job_candidate_count -> candidate_count
                'job_expiry_date' => $input['job_expiry_date'],
                'job_release_date' => $input['job_release_date'] ?? Carbon::now()->format('Y-m-d'),
                'is_anonym' => $input['is_anonym'] ?? 0,
                'status' => $input['status'] ?? Job::STATUS_DRAFT,
                'company_id' => $input['company_id'],
            ];

            if ($job) {
                $job->update($jobData);
            } else {
                $job = Job::create($jobData);
            }

            $jobEducationFactory = new JobEducationFactory();
            $jobExperienceFactory = new JobExperienceFactory();
            $jobItSkillFactory = new JobItSkillFactory();
            $jobSoftwareSkillFactory = new JobSoftwareSkillFactory();
            $jobLanguageSkillFactory = new JobLanguageSkillFactory();
            $jobPersonalSkillFactory = new JobPersonalSkillFactory();
            $jobLocationFactory = new JobLocationFactory();
            $jobAssignedTypesFactory = new JobAssignedTypeFactory();
            $jobAssignedCategoryFactory = new JobAssignedCategoryFactory();
            $jobAssignedShiftFactory = new JobAssignedShiftFactory();
            $jobDrivingLicenseFactory = new JobDrivingLicenseFactory();

            if (isset($input['job_locations']) && !empty($input['job_locations'])) {
                $data = [];
                foreach ($input['job_locations'] as $item) {
                    $objPostalCode = (new PostalCodeFactory())->getByCityId($item);

                    $data[] = [
                        'city_id' => $item,
                        'postcode_id' => $objPostalCode->id,
                    ];
                }

                $save = $jobLocationFactory->createOrUpdate($job, $data);

                if (!$save) {
                    throw new \Exception('Hiba mentés közben');
                }
            } else {
                $jobLocationFactory->clearByJob($job);
            }
            if (isset($input['job_types']) && !empty($input['job_types'])) {
                $data = [];
                if (\is_array($input['job_types'])) {
                    foreach ($input['job_types'] as $item) {
                        $data[] = [
                            'job_type_id' => $item,
                        ];
                    }
                } else {
                    $data[0]['job_type_id'] = $input['job_types'];
                }

                $save = $jobAssignedTypesFactory->createOrUpdate($job, $data);

                if (!$save) {
                    throw new \Exception('Hiba mentés közben');
                }
            } else {
                $jobAssignedTypesFactory->clearByJob($job);
            }
            if (isset($input['job_shifts']) && !empty($input['job_shifts'])) {
                $data = [];
                foreach ($input['job_shifts'] as $item) {
                    $data[] = [
                        'job_shift_id' => $item,
                    ];
                }

                $save = $jobAssignedShiftFactory->createOrUpdate($job, $data);

                if (!$save) {
                    throw new \Exception('Hiba mentés közben');
                }
            } else {
                $jobAssignedShiftFactory->clearByJob($job);
            }

            if (isset($input['job_categories']) && !empty($input['job_categories'])) {
                $data = [];
                foreach ($input['job_categories'] as $item) {
                    $data[] = [
                        'job_category_id' => $item,
                    ];
                }

                $save = $jobAssignedCategoryFactory->createOrUpdate($job, $data);

                if (!$save) {
                    throw new \Exception('Hiba mentés közben');
                }
            } else {
                $jobAssignedCategoryFactory->clearByJob($job);
            }

            if (isset($input['jobRequirements'])) {
                $requirements = $input['jobRequirements'];
                if (isset($requirements['education']) && !empty($requirements['education'])) {
                    $data = [];
                    foreach ($requirements['education'] as $item) {
                        $data[] = [
                            'name' => $item['education_name'] ?: '',
                            'degree_level_id' => $item['education_level'],
                        ];
                    }

                    $saveEducations = $jobEducationFactory->createOrUpdate($job, $data);

                    if (!$saveEducations) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobEducationFactory->clearByJob($job);
                }
                if (isset($requirements['experience']) && !empty($requirements['experience'])) {
                    $data = [];
                    foreach ($requirements['experience'] as $item) {
                        $data[] = [
                            'position' => $item['experience_position'] ?: '',
                            'years' => $item['experience_years'] ?: '',
                        ];
                    }

                    $saveExperience = $jobExperienceFactory->createOrUpdate($job, $data);

                    if (!$saveExperience) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobExperienceFactory->clearByJob($job);
                }
                if (isset($requirements['drivers_license']) && !empty($requirements['drivers_license'])) {
                    $data = [];
                    foreach ($requirements['drivers_license'] as $item) {
                        $data[] = [
                            'driving_license_id' => $item['drivers_license_id'],
                        ];
                    }
                    $save = $jobDrivingLicenseFactory->createOrUpdate($job, $data);

                    if (!$save) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobDrivingLicenseFactory->clearByJob($job);
                }

                if (isset($requirements['it_skill']) && !empty($requirements['it_skill'])) {
                    $data = [];
                    foreach ($requirements['it_skill'] as $item) {
                        $data[] = [
                            'name' => $item['it_skill_name'] ?: '',
                            'skill_level_id' => $item['it_skill_level'],
                        ];
                    }

                    $saveItSkill = $jobItSkillFactory->createOrUpdate($job, $data);

                    if (!$saveItSkill) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobItSkillFactory->clearByJob($job);
                }

                if (isset($requirements['software_skill']) && !empty($requirements['software_skill'])) {
                    $data = [];
                    foreach ($requirements['software_skill'] as $item) {
                        $data[] = [
                            'name' => $item['software_skill_name'] ?: '',
                            'skill_level_id' => $item['software_skill_level'],
                        ];
                    }

                    $saveSoftwareSkill = $jobSoftwareSkillFactory->createOrUpdate($job, $data);

                    if (!$saveSoftwareSkill) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobSoftwareSkillFactory->clearByJob($job);
                }
                if (isset($requirements['language_skill']) && !empty($requirements['language_skill'])) {
                    $data = [];
                    foreach ($requirements['language_skill'] as $item) {
                        $data[] = [
                            'language_id' => $item['language_skill_id'],
                            'language_level_id' => $item['language_skill_level'],
                        ];
                    }
                    $saveLanguageSkill = $jobLanguageSkillFactory->createOrUpdate($job, $data);

                    if (!$saveLanguageSkill) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobLanguageSkillFactory->clearByJob($job);
                }
                if (isset($requirements['personal_skill']) && !empty($requirements['personal_skill'])) {
                    $data = [];
                    foreach ($requirements['personal_skill'] as $item) {
                        $data[] = [
                            'name' => $item['personal_skill_name'] ?: '',
                        ];
                    }

                    $savePersonalSkill = $jobPersonalSkillFactory->createOrUpdate($job, $data);

                    if (!$savePersonalSkill) {
                        throw new \Exception('Hiba mentés közben');
                    }
                } else {
                    $jobPersonalSkillFactory->clearByJob($job);
                }
            } else {
                $jobEducationFactory->clearByJob($job);
                $jobExperienceFactory->clearByJob($job);
                $jobItSkillFactory->clearByJob($job);
                $jobSoftwareSkillFactory->clearByJob($job);
                $jobLanguageSkillFactory->clearByJob($job);
                $jobPersonalSkillFactory->clearByJob($job);
                $jobDrivingLicenseFactory->clearByJob($job);
            }

            if (isset($requirements['drivers_license']) && !empty($requirements['drivers_license'])) {
                $jobDrivingLicenseFactory = new JobDrivingLicenseFactory();
                $data = [];
                foreach ($requirements['drivers_license'] as $item) {
                    if (!empty($item['drivers_license_id'])) {  // FONTOS: már drivers_license_id van, nem drivers_license_name
                        $data[] = ['driving_license_id' => $item['drivers_license_id']];
                    }
                }
                $jobDrivingLicenseFactory->createOrUpdate($job, $data);
            } else {
                $jobDrivingLicenseFactory->clearByJob($job);
            }
            \DB::commit();
            //            /** @var JobType $jobType */
            //            $jobType = JobType::with('candidateJobAlerts')->whereId($input['job_type_id'])->first();
            //            $userIds = $jobType->candidateJobAlerts->where('job_alert', '=', 1)->pluck('user_id');
            //            $notificationAlertUserIds = $jobType->candidateJobAlerts->pluck('user_id');
            //            $users = User::whereIn('id', $userIds)->get();
            //            $notificationAlertUsers = User::whereIn('id', $notificationAlertUserIds)->get();
            //            if ($job->status != Job::STATUS_DRAFT) {
            //                foreach ($notificationAlertUsers as $user) {
            //                    NotificationSetting::whereKey(Notification::JOB_ALERT)->first()->value == 1 ?
            //                        addNotification([
            //                            Notification::JOB_ALERT,
            //                            $user->id,
            //                            Notification::CANDIDATE,
            //                            'New job posted with '.$job->job_title.', if you are interested then you can apply for this job.',
            //                        ]) : false;
            //                }
            //                /** @var EmailTemplate $templateBody */
            //                $templateBody = EmailTemplate::whereTemplateName('Job Alert')->first();
            //                foreach ($users as $user) {
            //                    $job->name = $user->full_name;
            //                    $keyVariable = ['{{job_name}}', '{{job_url}}', '{{job_title}}', '{{from_name}}'];
            //                    $value = [$job->name, asset('/job-details/'.$job->job_id), $job->job_title, config('app.name')];
            //                    $body = str_replace($keyVariable, $value, $templateBody->body);
            //                    $data['body'] = $body;
            //                    Mail::to($user->email)->send(new EmailToCandidate($data));
            //                }
            //            }

            return $job;
        } catch (\Exception $e) {
            \DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     * @param Job   $job
     *
     * @throws \Throwable
     *
     * @return bool|Builder|Builder[]|Collection|Model
     */
    public function update($input, $job)
    {
        try {
            \DB::beginTransaction();
            //            $input['salary_from'] = (float) removeCommaFromNumbers($input['salary_from']);
            //            $input['salary_to'] = (float) removeCommaFromNumbers($input['salary_to']);
            //            // update Job
            //            if (isset($input['state_id']) && ! is_numeric($input['state_id'])) {
            //                $input['state_id'] = null;
            //            }
            //            if ($job->status == Job::STATUS_DRAFT) {
            //                $job->status = Job::STATUS_ACTIVE;
            //            }
            $job->update($input);
            //
            //            if (isset($input['jobsSkill']) && ! empty($input['jobsSkill'])) {
            //                $job->jobsSkill()->sync($input['jobsSkill']);
            //            }
            //            if (isset($input['jobTag']) && ! empty($input['jobTag'])) {
            //                $job->jobsTag()->sync($input['jobTag']);
            //            } else {
            //                $job->jobsTag()->sync([]);
            //            }

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            \DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param int $jobId
     *
     * @return mixed
     */
    public function isJobAddedToFavourite($jobId)
    {
        return FavouriteJob::where('user_id', Auth::user()->id)->where('job_id', $jobId)->exists();
    }

    /**
     * @param int $jobId
     *
     * @return mixed
     */
    public function isJobReportedAsAbuse($jobId)
    {
        return ReportedJob::where('user_id', Auth::user()->id)->where('job_id', $jobId)->exists();
    }

    /**
     * @return mixed
     */
    public function getJobDetails(Job $job)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Candidate $candidate */
        $candidate = Candidate::findOrFail($user->candidate->id);

        /** @var JobApplicationRepository $jobApplicationRepo */
        $jobApplicationRepo = app(JobApplicationRepository::class);

        // check candidate is already applied for job
        $data['isApplied'] = $jobApplicationRepo->checkJobStatus(
            $job->id,
            $candidate->id,
            JobApplication::STATUS_APPLIED
        );

        // check job is drafted
        $data['isJobDrafted'] = $data['isJobApplicationRejected'] = $data['isJobApplicationCompleted'] = false;
        if (!$data['isApplied']) {
            // check job is drafted or not
            $data['isJobDrafted'] = $jobApplicationRepo->checkJobStatus(
                $job->id,
                $candidate->id,
                JobApplication::STATUS_DRAFT
            );

            $data['isJobApplicationShortlisted'] = $jobApplicationRepo->checkJobStatus(
                $job->id,
                $candidate->id,
                JobApplication::SHORT_LIST
            );

            $data['isJobApplicationRejected'] = $jobApplicationRepo->checkJobStatus(
                $job->id,
                $candidate->id,
                JobApplication::REJECTED
            );

            $data['isJobApplicationCompleted'] = $jobApplicationRepo->checkJobStatus(
                $job->id,
                $candidate->id,
                JobApplication::COMPLETE
            );
        }

        $data['isJobAddedToFavourite'] = $this->isJobAddedToFavourite($job->id);
        $data['isJobReportedAsAbuse'] = $this->isJobReportedAsAbuse($job->id);

        return $data;
    }

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public function storeFavouriteJobs($input)
    {
        $job = Job::findOrFail($input['jobId']);
        $jobUser = Company::with('user')->findOrFail($job->company_id);
        $favouriteJob = FavouriteJob::where('user_id', $input['userId'])->where('job_id', $input['jobId'])->exists();
        if (!$favouriteJob) {
            FavouriteJob::create([
                'user_id' => $input['userId'],
                'job_id' => $input['jobId'],
            ]);
            $loggedInUser = getLoggedInUser();
            1 === NotificationSetting::whereKey(Notification::FOLLOW_JOB)->first()->value
                ? addNotification([
                    Notification::FOLLOW_JOB,
                    $jobUser->user->id,
                    Notification::EMPLOYER,
                    $loggedInUser->first_name.' '.$loggedInUser->last_name.' started following '.$job->job_title.'.',
                ]) : false;

            return true;
        }
        FavouriteJob::where('user_id', $input['userId'])->where('job_id', $input['jobId'])->delete();

        return false;
    }

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public function storeReportJobAbuse($input)
    {
        $jobReportedAsAbuse = ReportedJob::where('user_id', $input['userId'])->where(
            'job_id',
            $input['jobId']
        )->exists();
        if (!$jobReportedAsAbuse) {
            $reportedJobNote = trim($input['note']);
            if (empty($reportedJobNote)) {
                throw ValidationException::withMessages([
                    'note' => 'The Note Field is required',
                ]);
            }
            ReportedJob::create([
                'user_id' => $input['userId'],
                'job_id' => $input['jobId'],
                'note' => $input['note'],
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public function emailJobToFriend($input)
    {
        try {
            \DB::beginTransaction();

            /** @var EmailJob $emailJob */
            $emailJob = EmailJob::create($input);

            /** @var EmailTemplate $templateBody */
            $templateBody = EmailTemplate::whereTemplateName('Email Job To Friend')->first()['body'];
            $keyVariable = ['{{friend_name}}', '{{job_url}}', '{{from_name}}'];
            $value = [$emailJob->friend_name, $emailJob->job_url, config('app.name')];
            $body = str_replace($keyVariable, $value, $templateBody);
            $data['body'] = $body;
            Mail::to($input['friend_email'])->send(new EmailJobToFriend($data));

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            \DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function canCreateMoreJobs()
    {
        /** @var Company $company */
        $company = Company::whereUserId(Auth::id())->first();

        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);
        // retrieve user's subscription
        $subscription = $subscriptionRepo->getUserSubscription($company->user_id);

        if ($subscription) {
            // retrieve job count
            $jobCount = Job::query()->where('company_id', $company->id)->where('is_created_by_admin', 0)->count();

            $maxJobCount = Plan::whereId($subscription->plan_id)->value('allowed_jobs');

            if ($maxJobCount > $jobCount) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $reportedJobID
     *
     * @return null|Builder|Builder[]|Collection|Model
     */
    public function getReportedJobs($reportedJobID)
    {
        return ReportedJob::with(['user.candidate', 'job.company'])->without([
            'user.media', 'user.country', 'user.state', 'user.city',
        ])->select('reported_jobs.*')->orderBy(
            'created_at',
            'desc'
        )->findOrFail($reportedJobID);
    }
}
