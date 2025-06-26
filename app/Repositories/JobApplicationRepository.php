<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Models\Factories\JobApplicationResumeFactory;
use App\Models\Job;
use App\Models\JobApplication;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobApplicationRepository
 */
class JobApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_id',
        'resume_id',
        'expected_salary',
        'notes',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobApplication::class;
    }

    /**
     * @param  int  $jobId
     * @param  int  $candidateId
     * @param  int  $status
     *
     * @return mixed
     */
    public function checkJobStatus($jobId, $candidateId, $status)
    {
        return JobApplication::where('job_id', $jobId)
            ->where('candidate_id', $candidateId)
            ->where('status', $status)
            ->exists();
    }

    /**
     * @param  int  $jobId
     *
     * @return mixed
     */
    public function showApplyJobForm($jobId)
    {
        /** @var Candidate $candidate */
        $candidate = Candidate::findOrFail(Auth::user()->owner_id);

        /** @var Job $job */
        $job = Job::whereJobId($jobId)->first();
        $data['isActive'] = ($job->status == Job::STATUS_ACTIVE) ? true : false;

        $jobRepo = app(JobRepository::class);
        $data['isApplied'] = $this->checkJobStatus($job->id, $candidate->id, JobApplication::STATUS_APPLIED);

        $data['resumes'] = [];
        $data['isJobDrafted'] = false;
        if (! $data['isApplied']) {
            // get candidate resumes
            $data['resumes'] = $candidate->getMedia('resumes')->pluck('custom_properties.title' ,'id');
            $data['resumes_active'] = $candidate->getMedia('resumes')->pluck('custom_properties.active','id' );

            foreach ( $data['resumes'] as $key => $value){
                if(!$data['resumes_active'][$key]){
                    unset($data['resumes'][$key]);
                }
            }

            $data['default_resume'] = $candidate->getMedia('resumes', ['is_default' => true])->first();
            if (isset($data['default_resume'])) {
                $data['default_resume'] = $data['default_resume']->id;
            }

            // check job is drafted or not
            $data['isJobDrafted'] = $this->checkJobStatus($job->id, $candidate->id, JobApplication::STATUS_DRAFT);

            if ($data['isJobDrafted']) {
                $data['draftJobDetails'] = $job->appliedJobs()->where('candidate_id', $candidate->id)->first();
            }
        }
        $data['job'] = $job;

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function store($input)
    {
        try {
            $input['candidate_id'] = Auth::user()->owner_id;

            $job = Job::findOrFail($input['job_id']);
            if ($job->status != Job::STATUS_ACTIVE) {
                throw new UnprocessableEntityHttpException('job is not active.');
            }

            /** @var JobApplication $jobApplication */
            $jobApplication = JobApplication::where('job_id', $input['job_id'])
                ->where('candidate_id', $input['candidate_id'])
                ->first();

            if ($jobApplication && $jobApplication->status == JobApplication::STATUS_APPLIED) {
                throw new UnprocessableEntityHttpException(trans('messages.apply_job.already_applied'));
            }

            if ($jobApplication && $jobApplication->status == JobApplication::STATUS_DRAFT) {
                $jobApplication->delete();
            }

            $input['candidate_id'] = Auth::user()->owner_id;
            $input['status'] = $input['application_type'] == 'apply' ? JobApplication::STATUS_APPLIED : JobApplication::STATUS_DRAFT;

            $arrApplicationData = Arr::except($input, ['resumes', '_token']);

            $objJobApplication = $this->create($arrApplicationData);

            $jobApplicationResumeFactory = new JobApplicationResumeFactory();
            if (isset($input['resumes']) && ! empty($input['resumes'])) {
                $data = [];
                foreach($input['resumes'] as $item){
                    $data[] = [
                        'resume_id' => $item,
                    ];
                }

                $saveExperience = $jobApplicationResumeFactory->createOrUpdate($objJobApplication, $data);

                if (!$saveExperience) {
                    throw new Exception("Hiba mentés közben");
                }
            }
            else{
                $jobApplicationResumeFactory->clearByJobApplication($objJobApplication);
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  JobApplication  $jobApplication
     *
     * @return array
     */
    public function downloadMedia($jobApplication)
    {
        try {
            $documentMedia = Media::find($jobApplication->resume_id);
            if ($documentMedia == null) {
                $documentMedia = Media::where('model_id', $jobApplication->candidate_id)->where('collection_name',
                    'resumes')->latest()->first();
            }
            $documentPath = $documentMedia->getPath();
            if (config('app.media_disc') === 'public') {
                $documentPath = (Str::after($documentMedia->getUrl(), '/uploads'));
            }

            $file = Storage::disk(config('app.media_disc'))->get($documentPath);

            $headers = [
                'Content-Type'        => $documentMedia->mime_type,
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => "attachment; filename={$documentMedia->file_name}",
                'filename'            => $documentMedia->file_name,
            ];

            return [$file, $headers];
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
