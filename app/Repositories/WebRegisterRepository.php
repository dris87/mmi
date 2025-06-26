<?php

namespace App\Repositories;

use App;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\Candidates\CandidateRepository;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * Class WebRegisterRepository
 * @version July 7, 2020, 5:07 am UTC
 */
class WebRegisterRepository
{
    /**
     * @return mixed
     */
    public function getSettingForReCaptcha()
    {
        return Setting::where('key', 'enable_google_recaptcha')->first()->value;
    }

    /**
     * @param array $input
     *
     * @return bool
     * @throws Throwable
     *
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();

            $userInput = Arr::except($input, ['type']);
            $userInput['password'] = Hash::make($input['password']);
            /** @var User $user */
            $user = User::create($userInput);
            $userRole = Role::where('name', ($input['type'] == 1) ? 'Candidate' : 'Employer')->first();
            $user->assignRole($userRole);
            $adminId = User::role('Admin')->first()->id;

            /** @var CandidateRepository $candidateRepo */
            $candidateRepo = App::make(CandidateRepository::class);
            $candidate = Candidate::create([
                                               'user_id' => $user->id,
                                               'unique_id' => $candidateRepo->getUniqueCandidateId(),
                                           ]);
            $user->update(['owner_id' => $candidate->id, 'owner_type' => Candidate::class]);
            NotificationSetting::whereKey(Notification::NEW_CANDIDATE_REGISTERED)->first()->value == 1 ?
                addNotification([
                                    Notification::NEW_CANDIDATE_REGISTERED,
                                    $adminId,
                                    Notification::ADMIN,
                                    'New Candidate Registered',
                                ]) : false;

            $user->sendEmailVerificationNotification();

            $activity_log_text = "Munkavállalói regisztráció";
            activity()
                ->inLog("custom")
                ->performedOn($user)
                ->log($activity_log_text)
                ->causer($user);
            DB::commit();
            return $user;

        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
