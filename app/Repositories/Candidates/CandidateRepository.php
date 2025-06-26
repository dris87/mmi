<?php

namespace App\Repositories\Candidates;

use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateExtraQualifications;
use App\Models\CandidateStatus;
use App\Models\CareerLevel;
use App\Models\Circumstances;
use App\Models\City;
use App\Models\DrivingLicences;
use App\Models\ExtraRequirements;
use App\Models\Factories\CandidateAdvancedItSkillsFactory;
use App\Models\Factories\CandidateBasicItSkillsFactory;
use App\Models\Factories\CandidateExtraQualificationsFactory;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CandidateLanguageFactory;
use App\Models\Factories\CandidateSoftwareSkillsFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\Factories\UserFactory;
use App\Models\FunctionalArea;
use App\Models\Industry;
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\JobType;
use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\MaritalStatus;
use App\Models\SalaryCurrency;
use App\Models\Skill;
use App\Models\SkillLevel;
use App\Models\User;
use App\ReportedToCandidate;
use App\Repositories\BaseRepository;
use Arr;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Countries\Package\Countries;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Role;
use Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * Class CandidateRepository
 * @version July 20, 2020, 5:48 am UTC
 */
class CandidateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'father_name',
        'marital_status_id',
        'national_id_card',
        'experience',
        'career_level_id',
        'industry_id',
        'functional_area_id',
        'expected_salary',
        'immediate_available',
        'is_active',
    ];


    public function getCandidateFullData($objCandidate, $user): array
    {


        $data = [];
        $data['user'] = $user;
        $data['candidateExperiences'] = CandidateExperience::where('candidate_id',
                                                                   $user->owner_id)->orderByDesc('id')->get();

        foreach ($data['candidateExperiences'] as $experience) {
            $experience->country = getCountryName($experience->country_id);
        }
        $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where('candidate_id',
                                                                                      $user->owner_id)->orderByDesc('id')->get();
        foreach ($data['candidateEducations'] as $education) {
            $education->country = getCountryName($education->country_id);
        }

        return $data;

    }
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
        return Candidate::class;
    }

    /**
     * @return mixed
     */
    public function prepareData()
    {
        $countries = new Countries();
        $data['countries'] = getCountries();
        $data['maritalStatus'] = MaritalStatus::toBase()->pluck('marital_status', 'id');
        $data['careerLevel'] = CareerLevel::toBase()->pluck('level_name', 'id');
        $data['industry'] = Industry::toBase()->pluck('name', 'id');
        $data['functionalArea'] = FunctionalArea::toBase()->pluck('name', 'id');
        $data['skills'] = Skill::toBase()->pluck('name', 'id');
        $data['jobCategories'] = JobCategory::toBase()->pluck('name', 'id');
        $data['jobShifts'] = JobShift::toBase()->pluck('shift', 'id');
        $data['jobTypes'] = JobType::toBase()->pluck('name', 'id');
        $data['language'] = Language::toBase()->pluck('language', 'id');
        $data['currency'] = SalaryCurrency::toBase()->pluck('currency_name', 'id');
        $data['cities'] = City::toBase()->pluck('name', 'id');
        $data['statuses'] = CandidateStatus::toBase()->pluck('name', 'id');
        $data['language_level'] = LanguageLevel::toBase()->pluck('name', 'id');
        $data['skill_level'] = SkillLevel::toBase()->pluck('name', 'id');
        $data['extra_requirements'] = ExtraRequirements::toBase()->pluck('name', 'id');
        $data['circumstances'] = Circumstances::toBase()->pluck('name', 'id');
        $data['driving_lincences'] = DrivingLicences::toBase()->pluck('name', 'id');

        return $data;
    }

    /**
     * @return mixed
     */
    public function getUniqueCandidateId()
    {
        $candidateUniqueId = Str::random(12);
        while (true) {
            $isExist = Candidate::whereUniqueId($candidateUniqueId)->exists();
            if ($isExist) {
                self::getUniqueCandidateId();
            }
            break;
        }

        return $candidateUniqueId;
    }

    /**
     * @param array $input
     *
     * @return bool|Candidate
     * @throws Throwable
     *
     */
    public function store($input)
    {
        $CandidateExtraQualificationsFactory = new CandidateExtraQualificationsFactory();
        $CandidateLanguageFactory = new CandidateLanguageFactory();
        $CandidateBasicItSkillsFactory = new CandidateBasicItSkillsFactory();
        $CandidateAdvancedItSkillsFactory = new CandidateAdvancedItSkillsFactory();
        $CandidateSoftwareSkillsFactory = new CandidateSoftwareSkillsFactory();

        try {
            $PostalCodeFactory = new PostalCodeFactory();
            DB::beginTransaction();
            $input['is_active'] = isset($input['is_active']) ? 1 : 0;
            $input['is_verified'] = isset($input['is_verified']) ? 1 : 0;
            $input['password'] = Hash::make($input['password']);
            $input['dob'] = (!empty($input['dob'])) ? $input['dob'] : null;
            $input['expected_salary'] = intval(str_replace(",", "", $input['expected_salary']));
            $input['expected_salary_to'] = intval(str_replace(",", "", $input['expected_salary_to']));

            $input['unique_id'] = $this->getUniqueCandidateId();
            $candidateRole = Role::whereName('Candidate')->first();
            /** @var User $user */
            $user = User::create(Arr::only($input, (new User())->getFillable()));

            $candidate = Candidate::create(
                array_merge(
                    array_filter(Arr::only($input, (new Candidate())->getFillable())),
                    ['user_id' => $user->id]
                )
            );

            $objPostCode = $PostalCodeFactory->getByPostalCode($input["zipCode"]);

            /** @var $candidate Candidate */
            $candidate->update(
                [
                    'candidate_status_id' => $input['candidate_status_id'],
                    'immediate_available' => $input['immediate_available'],
                    'city_id' => $objPostCode->city_id,
                    'expected_salary' => intval(str_replace(",", "", $input['expected_salary'])),
                    'expected_salary_to' => intval(str_replace(",", "", $input['expected_salary_to'])),
                    'travel_max_distance' => !empty($input['able_to_travel_distance']) ? intval(
                        $input['able_to_travel_distance']
                    ) : null,
                    'move_anywhere' => isset($input['able_to_move_anywhere']) ? 1 : 0,
                    'postcode_id' => $objPostCode->id
                ]
            );

            $objCandidateExtraQualifications = $CandidateExtraQualificationsFactory->createOrUpdate(
                $candidate,
                $input["hobbies"],
                $input["other_comments"]
            );

            $ownerId = $candidate->id;
            $ownerType = Candidate::class;

            $user->update(['owner_id' => $ownerId, 'owner_type' => $ownerType]);
            $user->assignRole($candidateRole);



            if (is_array($input['candidateLanguageLevel']) && $input['candidateLanguageLevel']) {
                $saveLanguages = $CandidateLanguageFactory->createOrUpdate(
                    $user,
                    $input['candidateLanguage'],
                    $input['candidateLanguageLevel']
                );
                if (!$saveLanguages) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['basic_it_skills']) && $input['candidateBasicItSkillLevel']) {
                $saveCandidateBasicItSkills = $CandidateBasicItSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['basic_it_skills'],
                    $input['candidateBasicItSkillLevel']
                );
                if (!$saveCandidateBasicItSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['advanced_it_skills']) && $input['candidateAdvancedItSkillLevel']) {
                $saveCandidateAdvancedItSkills = $CandidateAdvancedItSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['advanced_it_skills'],
                    $input['candidateAdvancedItSkillLevel']
                );
                if (!$saveCandidateAdvancedItSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['software_skills']) && $input['candidateSoftwareSkillLevel']) {
                $saveCandidateSoftwareSkills = $CandidateSoftwareSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['software_skills'],
                    $input['candidateSoftwareSkillLevel']
                );
                if (!$saveCandidateSoftwareSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (isset($input['candidateSkills']) && !empty($input['candidateSkills'])) {
                $user->candidateSkill()->sync($input['candidateSkills']);
            }

            if (isset($input['candidateJobCategories']) && !empty($input['candidateJobCategories'])) {
                $candidate->candidateJobCategories()->sync($input['candidateJobCategories']);
            }

            if (isset($input['candidateJobShifts']) && !empty($input['candidateJobShifts'])) {
                $candidate->candidateJobShift()->sync($input['candidateJobShifts']);
            }

            if (isset($input['candidatejobTypes']) && !empty($input['candidatejobTypes'])) {
                $candidate->candidateJobType()->sync($input['candidatejobTypes']);
            }

            if (isset($input['candidateAbleToTravelCities']) && !empty($input['candidateAbleToTravelCities'])) {
                $candidate->candidateAbleToTravelCity()->sync($input['candidateAbleToTravelCities']);
            }

            if (isset($input['candidateAbleToMoveCities']) && !empty($input['candidateAbleToMoveCities'])) {
                $candidate->candidateAbleToMoveCity()->sync($input['candidateAbleToMoveCities']);
            }

            if (isset($input['candidateExtraRequirements']) && !empty($input['candidateExtraRequirements'])) {
                $candidate->candidateExtraRequirements()->sync($input['candidateExtraRequirements']);
            }

            if (isset($input['candidateCircumstances']) && !empty($input['candidateCircumstances'])) {
                $candidate->candidateCircumstances()->sync($input['candidateCircumstances']);
            }

            if (isset($input['candidateDrivingLicence']) && !empty($input['candidateDrivingLicence'])) {
                $candidate->candidateDrivingLicence()->sync($input['candidateDrivingLicence']);
            }

            if ((isset($input['image']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['image'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }


            $causer = Auth::user();
            activity()
                ->performedOn($candidate)
                ->log('Új munkavállaló hozzáadás')
                ->causer($causer);

            if ($user->is_verified) {
                $user->update(['email_verified_at' => Carbon::now()]);
            } else {
                //$user->sendEmailVerificationNotification();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return $candidate;
    }

    /**
     * @param array $input
     *
     * @return bool
     * @throws Throwable
     *
     */
    public function updateProfile($input)
    {
        $CandidateExtraQualificationsFactory = new CandidateExtraQualificationsFactory();
        $CandidateLanguageFactory = new CandidateLanguageFactory();
        $CandidateBasicItSkillsFactory = new CandidateBasicItSkillsFactory();
        $CandidateAdvancedItSkillsFactory = new CandidateAdvancedItSkillsFactory();
        $CandidateSoftwareSkillsFactory = new CandidateSoftwareSkillsFactory();

        $PostalCodeFactory = new PostalCodeFactory();
        $UserFactory = new UserFactory();
        try {
            DB::beginTransaction();

            $input['dob'] = (!empty($input['dob'])) ? $input['dob'] : null;
            $input['is_active'] = isset($input['is_active']) ? 1 : 0;
            $input['is_verified'] = isset($input['is_verified']) ? 1 : 0;

            if (isset($input['user_id'])) {
                /** @var User $user */
                $user = $UserFactory->getById($input['user_id']);
            } else {
                /** @var User $user */
                $user = Auth::user();
            }

            $userInput = Arr::only(
                $input,
                [
                    'able_to_travel_distance',
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'candidate_status_id',
                    'phone',
                    'country_id',
                    'state_id',
                    'city_id',
                    'gender',
                    'dob',
                    'facebook_url',
                    'twitter_url',
                    'linkedin_url',
                    'is_active',
                    'is_verified',
                    'pinterest_url',
                    'google_plus_url',
                    'region_code'
                ]
            );

            $user->update($userInput);

            if ((isset($input['image']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['image'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            $objPostCode = $PostalCodeFactory->getByPostalCode($input["zipCode"]);

            $input['available_at'] = $input['immediate_available'] == 0 ? $input['available_at'] : null;
            $input['city_id'] = $objPostCode->city_id;
            $input['postcode_id'] = $objPostCode->id;
            $input['expected_salary'] = intval(str_replace(",", "", $input['expected_salary']));
            $input['expected_salary_to'] = intval(str_replace(",", "", $input['expected_salary_to']));
            $input['travel_max_distance'] = !empty($input['able_to_travel_distance']) ? intval(
                $input['able_to_travel_distance']
            ) : null;
            $input['move_anywhere'] = isset($input['able_to_move_anywhere']) ? 1 : 0;
            $user->candidate->update($input);

            $candidate = $user->candidate;

            $objCandidateExtraQualifications = $CandidateExtraQualificationsFactory->createOrUpdate(
                $candidate,
                $input["hobbies"],
                $input["other_comments"]
            );

            if (is_array($input['candidateLanguageLevel']) && $input['candidateLanguageLevel']) {
                $saveLanguages = $CandidateLanguageFactory->createOrUpdate(
                    $user,
                    $input['candidateLanguage'],
                    $input['candidateLanguageLevel']
                );
                if (!$saveLanguages) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['basic_it_skills']) && $input['candidateBasicItSkillLevel']) {
                $saveCandidateBasicItSkills = $CandidateBasicItSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['basic_it_skills'],
                    $input['candidateBasicItSkillLevel']
                );
                if (!$saveCandidateBasicItSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['advanced_it_skills']) && $input['candidateAdvancedItSkillLevel']) {
                $saveCandidateAdvancedItSkills = $CandidateAdvancedItSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['advanced_it_skills'],
                    $input['candidateAdvancedItSkillLevel']
                );
                if (!$saveCandidateAdvancedItSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (is_array($input['software_skills']) && $input['candidateSoftwareSkillLevel']) {
                $saveCandidateSoftwareSkills = $CandidateSoftwareSkillsFactory->createOrUpdate(
                    $candidate,
                    $input['software_skills'],
                    $input['candidateSoftwareSkillLevel']
                );
                if (!$saveCandidateSoftwareSkills) {
                    throw new Exception("Hiba mentés közben");
                }
            }

            if (isset($input['candidateSkills']) && !empty($input['candidateSkills'])) {
                $user->candidateSkill()->sync($input['candidateSkills']);
            } else {
                $user->candidateSkill()->sync([]);
            }

            if (isset($input['candidateJobCategories']) && !empty($input['candidateJobCategories'])) {
                $candidate->candidateJobCategories()->sync($input['candidateJobCategories']);
            } else {
                $candidate->candidateJobCategories()->sync([]);
            }

            if (isset($input['candidateJobShifts']) && !empty($input['candidateJobShifts'])) {
                $candidate->candidateJobShift()->sync($input['candidateJobShifts']);
            } else {
                $candidate->candidateJobShift()->sync([]);
            }

            if (isset($input['candidateJobTypes']) && !empty($input['candidateJobTypes'])) {
                $candidate->candidateJobType()->sync($input['candidateJobTypes']);
            } else {
                $candidate->candidateJobType()->sync([]);
            }

            if (isset($input['candidateAbleToTravelCities']) && !empty($input['candidateAbleToTravelCities'])) {
                $candidate->candidateAbleToTravelCity()->sync($input['candidateAbleToTravelCities']);
            } else {
                $candidate->candidateAbleToTravelCity()->sync([]);
            }

            if (isset($input['candidateAbleToMoveCities']) && !empty($input['candidateAbleToMoveCities'])) {
                $candidate->candidateAbleToMoveCity()->sync($input['candidateAbleToMoveCities']);
            } else {
                $candidate->candidateAbleToMoveCity()->sync([]);
            }

            if (isset($input['candidateExtraRequirements']) && !empty($input['candidateExtraRequirements'])) {
                $candidate->candidateExtraRequirements()->sync($input['candidateExtraRequirements']);
            } else {
                $candidate->candidateExtraRequirements()->sync([]);
            }

            if (isset($input['candidateCircumstances']) && !empty($input['candidateCircumstances'])) {
                $candidate->candidateCircumstances()->sync($input['candidateCircumstances']);
            }else {
                $candidate->candidateCircumstances()->sync([]);
            }

            if (isset($input['candidateDrivingLicence']) && !empty($input['candidateDrivingLicence'])) {
                $candidate->candidateDrivingLicence()->sync($input['candidateDrivingLicence']);
            }else {
                $candidate->candidateDrivingLicence()->sync([]);
            }

            $causer = Auth::user();
            activity()
                ->inLog("custom")
                ->performedOn($candidate)
                ->log('Munkavállaló adatmódosítás')
                ->causer($causer);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     *
     * @return bool
     * @throws Throwable
     *
     */
    public function updateGeneralInformation($input)
    {
        try {
            DB::beginTransaction();
            /** @var User $user */
            $user = Auth::user();
            $userInput = Arr::only($input, [
                'first_name',
                'last_name',
                'country_id',
                'state_id',
                'city_id',
                'phone',
                'facebook_url',
                'twitter_url',
                'linkedin_url',
                'google_plus_url',
                'pinterest_url',
            ]);
            $user->update($userInput);
            $user->candidate->update($input);
            //Update Candidate Skills
            if (isset($input['candidateSkills']) && !empty($input['candidateSkills'])) {
                $user->candidateSkill()->sync($input['candidateSkills']);
            }
            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function uploadResume($input)
    {
        try {
            if (isset($input["candidate_id"])) {
                /** @var Candidate $candidate */
                $candidate = (new CandidateFactory())->getById($input["candidate_id"]);
                $user = (new UserFactory())->getById($candidate->user_id);
            } else {
                $user = Auth::user();
            }

            /** @var Candidate $candidate */
            $candidate = Candidate::findOrFail($user->candidate->id);
            $input['is_default'] = isset($input['is_default']) ? true : false;
            $fileExtension = getFileName('download', $input['file']);
            $media = $candidate->addMedia($input['file'])
                ->withCustomProperties([
                                           'active' => $input['is_default'],
                                           'language' => $input['resumeLanguage'],
                                           'title' => $input['title'],
                                       ])
                ->usingFileName($fileExtension)
                ->toMediaCollection(
                    Candidate::RESUME_PATH,
                    config('app.media_disc')
                );

            return $media;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function uploadDocument($input)
    {
        try {
            if (isset($input["candidate_id"])) {
                /** @var Candidate $candidate */
                $candidate = (new CandidateFactory())->getById($input["candidate_id"]);
                $user = (new UserFactory())->getById($candidate->user_id);
            } else {
                $user = Auth::user();
            }

            /** @var Candidate $candidate */
            $candidate = Candidate::findOrFail($user->candidate->id);
            $fileExtension = getFileName('download', $input['file']);
            $media = $candidate->addMedia($input['file'])
                ->withCustomProperties([
                                           'title' => $input['title']
                                       ])
                ->usingFileName($fileExtension)
                ->toMediaCollection(
                    Candidate::CANDIDATE_DOCUMENT_PATH,
                    config('app.media_disc')
                );

            return $media;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param Candidate $candidate
     * @param array $input
     *
     * @return bool
     */
    public function updateCandidate($candidate, $input)
    {
        unset($input['password']);

        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['is_verified'] = isset($input['is_verified']) ? 1 : 0;
        $input['dob'] = (!empty($input['dob'])) ? $input['dob'] : null;
        $input['available_at'] = $input['immediate_available'] == 0 ? $input['available_at'] : null;

        /** @var User $user */
        $user = $candidate->user;

        /* @var Candidate $candidate */
        $user->update($input);
        $candidate->update($input);

        if (!$user->email_verified_at && $input['is_verified'] == 1) {
            $user->update(['email_verified_at' => Carbon::now()]);
        }

        //Update Candidate Skills
        if (isset($input['candidateSkills']) && !empty($input['candidateSkills'])) {
            $user->candidateSkill()->sync($input['candidateSkills']);
        }

        //update Candidate Languages
        if (isset($input['candidateLanguage']) && !empty($input['candidateLanguage'])) {
            $user->candidateLanguage()->sync($input['candidateLanguage']);
        }

        return true;
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function changePassword($input)
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            if (!Hash::check($input['password_current'], $user->password)) {
                throw new UnprocessableEntityHttpException('Current password is invalid.');
            }
            $input['password'] = Hash::make($input['password']);
            $user->update($input);

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function profileUpdate($input)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            $user->update($input);
            if ((isset($input['image']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['image'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param $candidate
     *
     * @return mixed
     */
    public function getCandidateDetail($candidate)
    {
        $candidateDetails = Candidate::with('user', 'functionalArea')->findOrFail($candidate);
        // update profile views count
        if ($candidateDetails->user->id != getLoggedInUserId()) {
            $candidateDetails->user->increment('profile_views');
        }
        $data['isReportedToCandidate'] = $this->isAlreadyReported($candidate);
        $data['candidateDetails'] = $candidateDetails;
        $data['candidateExperiences'] = CandidateExperience::where('candidate_id', $candidate)->get();
        foreach ($data['candidateExperiences'] as $experience) {
            $experience->country_name = getCountryName($experience->country_id);
        }
        $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where(
            'candidate_id',
            $candidate
        )->get();
        foreach ($data['candidateEducations'] as $education) {
            $education->country_name = getCountryName($education->country_id);
        }

        return $data;
    }

    /**
     * @param $companyId
     *
     * @return mixed
     */
    public function isAlreadyReported($candidateId)
    {
        return ReportedToCandidate::where('user_id', Auth::id())
            ->where('candidate_id', $candidateId)
            ->exists();
    }

    public function storeReportCandidate($input)
    {
        $candidateReportedAsAbuse = ReportedToCandidate::where('user_id', $input['userId'])
            ->where('candidate_id', $input['candidateId'])
            ->exists();

        if (!$candidateReportedAsAbuse) {
            $reportedCandidateNote = trim($input['note']);
            if (empty($reportedCandidateNote)) {
                throw ValidationException::withMessages([
                                                            'note' => 'The Note Field is required',
                                                        ]);
            }
            ReportedToCandidate::create([
                                            'user_id' => $input['userId'],
                                            'candidate_id' => $input['candidateId'],
                                            'note' => $input['note'],
                                        ]);

            return true;
        }

        return true;
    }

    /**
     * @param $reportedToCandidate
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getReportedToCandidate($reportedToCandidate)
    {
        $query = ReportedToCandidate::with([
                                               'user',
                                               'candidate.user',
                                           ])->select('reported_to_candidates.*')->findOrFail($reportedToCandidate);

        return $query;
    }

    /**
     * @return mixed
     */
    public function getJobAlerts()
    {
        $candidate = Candidate::with('jobAlerts')->whereUserId(Auth::id())->first();
        $data['jobTypes'] = JobType::all();
        $data['jobAlerts'] = $candidate->jobAlerts()->pluck('job_type_id')->toArray();
        $data['candidate'] = $candidate;

        return $data;
    }

    /**
     * @param $input
     *
     * @return bool
     */
    public function updateJobAlerts($input)
    {
        $candidate = Candidate::with('jobAlerts')->whereUserId(Auth::id())->first();
        try {
            $candidate->job_alert = (isset($input['job_alert'])) ? 1 : 0;
            $candidate->update();

            if (isset($input['job_types']) && !empty($input['job_types'])) {
                $candidate->jobAlerts()->sync($input['job_types']);
            } else {
                $candidate->jobAlerts()->sync([]);
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
