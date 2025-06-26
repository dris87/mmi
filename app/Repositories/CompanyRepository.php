<?php

namespace App\Repositories;

use App\Helpers\Video;
use App\Models\Company;
use App\Models\CompanySize;
use App\Models\Factories\CityFactory;
use App\Models\Factories\CompanyAwardFactory;
use App\Models\Factories\CompanySiteFactory;
use App\Models\Factories\CompanyUserFactory;
use App\Models\Factories\CompanyVideoFactory;
use App\Models\Factories\CoworkerPositionFactory;
use App\Models\Factories\PermissionFactory;
use App\Models\Factories\PositionFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\FavouriteCompany;
use App\Models\Industry;
use App\Models\Job;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\OwnerShipType;
use App\Models\ReportedToCompany;
use App\Models\User;
use Arr;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use PragmaRX\Countries\Package\Countries;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

/**
 * Class CompanyRepository
 * @version June 22, 2020, 12:34 pm UTC
 */
class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ceo',
        'established_in',
        'website',
        'is_active',
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
        return Company::class;
    }

    /**
     * @return mixed
     */
    public function prepareData()
    {
        $countries = new Countries();
        $data['industries'] = Industry::pluck('name', 'id');
        $data['ownerShipTypes'] = OwnerShipType::pluck('name', 'id');
        $data['companySize'] = CompanySize::pluck('size', 'id');
        $data['countries'] = getCountries();

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @throws Throwable
     *
     * @return bool
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();
            $postalCodeFactory = new PostalCodeFactory();

            $objPostalCode = $postalCodeFactory->getByPostalCode($input['zipCode']);

            if($objPostalCode){
                $cityFactory = new CityFactory();
                $objCity = $cityFactory->getById($objPostalCode->getCityId());
                if(!$objCity){
                    throw new Exception('Invalid postcode.');
                }
            }
            else{
                throw new Exception('Invalid postcode.');
            }

            $company = $this->create([
                'name'  => $input['companyName'],
                'representative' => $input['representative'],
                'vatNumber' => $input['vatNumber'],
                'city_id' => $objCity->id,
                'postcode_id' => $objPostalCode->getId(),
                'street'   => $input['street'],
                'address'   => $input['houseNumber'],
                'floor'   => $input['floor'] ?? '',
                'door'   => $input['door'] ?? '',
                'unique_id' => getUniqueCompanyId()
            ]);

            // Create User
            $input['password'] = Hash::make($input['password']);
            $input['owner_id'] = $company->id;
            $input['owner_type'] = Company::class;
            $input['is_verified'] = isset($input['is_verified']) ? 1 : 0;
            $input['first_name'] = $input['firstName'];
            $input['last_name'] = $input['lastName'];
            $userInput = Arr::only($input,
                [
                    'first_name', 'last_name', 'email', 'phone', 'password', 'owner_id', 'owner_type', 'country_id', 'state_id',
                    'city_id', 'is_active', 'dob', 'gender',
                    'facebook_url', 'twitter_url', 'linkedin_url', 'google_plus_url', 'pinterest_url', 'is_verified',
                    'region_code', 'position_id'
                ]);

            /** @var User $user */
            $user = User::create($userInput);
            $companyRole = Role::whereName('Employer')->first();
            $user->assignRole($companyRole);
            $company->update(['user_id' => $user->id]);

            if ((isset($input['image']))) {
                $user->addMedia($input['image'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            /** @var SubscriptionRepository $subscriptionRepo */
            $subscriptionRepo = app(SubscriptionRepository::class);
            $subscriptionRepo->createStripeCustomer($user);

            if ($user->is_verified) {
                $user->update(['email_verified_at' => Carbon::now()]);
            } else {
                $user->sendEmailVerificationNotification();
            }

            $companyUserFactory = new CompanyUserFactory();
            $permissionFactory = new PermissionFactory();
            $coworkerPositionFactory = new CoworkerPositionFactory();

            $objPermission = $permissionFactory->getFrontOfficeAdminPermission();
            $objCoworkerPosition = $coworkerPositionFactory->getDefaultPosition();

            $companyUserFactory->create($user, $company, $objPermission, $objCoworkerPosition, $input['phone']);


            DB::commit();

            return true;
        } catch (Exception $e) {

            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  array  $input
     * @param  Company  $company
     *
     * @throws Throwable
     *
     * @return bool|Builder|Builder[]|Collection|Model
     */
    public function update($input, $company)
    {
        try {
            DB::beginTransaction();

            //should remove: zipCode, city, houseNumber, mailing_zipCode, mailing_houseNumber
            $companyData = Arr::only($input, [
              'display_name', 'representative', 'vatNumber', 'companyNumber',
              'street', 'floor', 'door', 'is_paper_invoice', 'diff_mailing_address',
              'mailing_street','mailing_address', 'mailing_floor', 'mailing_door', 'website',
              'facebook_url', 'google_plus_url', 'linkedin_url', 'company_size', 'established_in',
              'industry_id', 'introduction', 'mission', 'why_work_with_us', 'user_id', 'company_id',
            ]);

            $companyData['name'] = $input['companyName'];
            $companyData['address'] = $input['houseNumber'];
            $companyData['mailing_address'] = $input['mailing_houseNumber'];
            $companyData['company_number'] = $input['companyNumber'];

            $postcodeFactory = new PostalCodeFactory();
            $cityFactory = new CityFactory();
            $positionFactory = new PositionFactory();

            if (isset($input['zipCode'])) {
                $postcode = $postcodeFactory->getByPostalCode($input['zipCode']);
                $companyData['postcode_id'] = $postcode->getId();
            }
            if (isset($input['city'])) {
                $city = $cityFactory->getByName($input['city']);
                $companyData['city_id'] = $city->getId();
            }
            if (isset($input['mailing_zipCode'])) {
                $mailingPostcode = $postcodeFactory->getByPostalCode($input['mailing_zipCode']);
                $companyData['mailing_postcode_id'] = $mailingPostcode->getId();
            }
            if (isset($input['mailing_city'])) {
                $mailingCity = $cityFactory->getByName($input['mailing_city']);
                $companyData['mailing_city_id'] = $mailingCity->getId();
            }

            $company->update($companyData);

//            $input['first_name'] = $input['name'];
//            $userInput = Arr::only($input,
//                [
//                    'first_name', 'email', 'phone', 'password', 'country_id', 'state_id', 'city_id', 'is_active',
//                    'facebook_url', 'twitter_url', 'linkedin_url', 'google_plus_url', 'pinterest_url', 'region_code',
//                ]);
//            /** @var User $user */
//            $user = $company->user;
//            $user->update($userInput);



            if ((isset($input['logo']))) {
                $company->clearMediaCollection(Company::LOGO);
                $company->addMedia($input['logo'])
                    ->toMediaCollection(Company::LOGO, config('app.media_disc'));
            }
            if ((isset($input['cover_photo']))) {
                $company->clearMediaCollection(Company::COVER_PHOTO);
                $company->addMedia($input['cover_photo'])
                    ->toMediaCollection(Company::COVER_PHOTO, config('app.media_disc'));
            }
            if ((isset($input['workplace_img']))) {
                $company->clearMediaCollection(Company::WORKPLACE_PHOTO);
                $company->addMedia($input['workplace_img'])
                    ->toMediaCollection(Company::WORKPLACE_PHOTO, config('app.media_disc'));
            }

            $companyVideoFactory = new CompanyVideoFactory();
            $companySiteFactory  = new CompanySiteFactory();
            $companyAwardFactory = new CompanyAwardFactory();


            if (isset($input['videos']) && ! empty($input['videos'])) {

                $save = $companyVideoFactory->createOrUpdate($company, $input['videos']);
                if (!$save) {
                    throw new Exception("Hiba mentés közben");
                }
            }
            else{
                $companyVideoFactory->clearByCompany($company);
            }

            if (isset($input['companyAwards']) && ! empty($input['companyAwards'])) {

                $save = $companyAwardFactory->createOrUpdate($company, $input['companyAwards']);

                if (!$save) {
                    throw new Exception("Hiba mentés közben");
                }
            }
            else{
                $companyAwardFactory->clearByCompany($company);
            }

            if(isset($input['companyGallery']) && ! empty($input['companyGallery'])) {

                $arrGallery = $company->getCompanyGallery();

                $editMode = false;

                foreach($arrGallery as $objMedia){
                    $found = false;
                    foreach($input['companyGallery'] as $galleryItem){
                        if(isset($galleryItem['id'])) {
                            $editMode = true;
                            if($objMedia->id == $galleryItem['id']){
                                $found = true;
                            }
                        }
                    }
                    if(!$found){
                        $objMedia->delete();
                    }
                }

                if(!$editMode) {
                    $company->clearMediaCollection(Company::GALLERY_PATH);
                }

                foreach($input['companyGallery'] as $item){
                    if(isset($item['image'])) {
                        $company->addMedia($item['image'])
                            ->toMediaCollection(Company::GALLERY_PATH, config('app.media_disc'));
                    }
                }
            }
            else{
                $company->clearMediaCollection(Company::GALLERY_PATH);
            }

            if (isset($input['companySites']) && ! empty($input['companySites'])) {

                $arrData = $input['companySites'];

                foreach($arrData as $key => $item){

                    $postcode = $postcodeFactory->getByPostalCode($item['zip_code']);

                    if($postcode) {
                        $arrData[$key]['postcode_id'] = $postcode->getId();
                    }
                    else{
                        throw new Exception("Érvénytelen irányítószám: ".$item['zip_code']);
                    }

                    $city = $cityFactory->getByName($item['city']);

                    if($city) {
                        $arrData[$key]['city_id'] = $city->getId();
                    }
                    else{
                        throw new Exception("Érvénytelen város: ". $item['city']);
                    }
                }

                $save = $companySiteFactory->createOrUpdate($company, $arrData);

                if (!$save) {
                    throw new Exception("Hiba mentés közben");
                }
            }
            else{
                $companySiteFactory->clearByCompany($company);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param $companyId
     *
     * @return mixed
     */
    public function isCompanyAddedToFavourite($companyId)
    {
        return FavouriteCompany::where('user_id', Auth::id())
            ->where('company_id', $companyId)
            ->exists();
    }

    /**
     * @param $companyId
     *
     * @return mixed
     */
    public function isReportedToCompany($companyId)
    {
        return ReportedToCompany::where('user_id', Auth::id())
            ->where('company_id', $companyId)
            ->exists();
    }

    /**
     * @param $companyId
     *
     * @return mixed
     */
    public function getCompanyDetail($companyId)
    {
        $data['companyDetail'] = Company::with('user')->findOrFail($companyId);
        $data['jobDetails'] = Job::with('jobShift', 'company', 'jobCategory')
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())
            ->where([
                ['company_id', $companyId], ['status', Job::STATUS_ACTIVE]
            ])->take(3)->get();
        $data['isCompanyAddedToFavourite'] = $this->isCompanyAddedToFavourite($companyId);
        $data['isReportedToCompany'] = $this->isReportedToCompany($companyId);

        return $data;
    }

    /**
     * @param  array  $input
     * @throws Exception
     *
     * @return bool
     */
    public function storeFavouriteJobs($input)
    {
        $favouriteJob = FavouriteCompany::where('user_id', $input['userId'])
            ->where('company_id', $input['companyId'])
            ->exists();
        if (! $favouriteJob) {
            $companyUser = User::findOrFail(Company::findOrFail($input['companyId'])->user_id);
            FavouriteCompany::create([
                'user_id'    => $input['userId'],
                'company_id' => $input['companyId'],
            ]);
            $user = getLoggedInUser();
            NotificationSetting::whereKey(Notification::FOLLOW_COMPANY)->first()->value == 1 ?
                addNotification([
                    Notification::FOLLOW_COMPANY,
                    $companyUser->id,
                    Notification::EMPLOYER,
                    $user->first_name.' '.$user->last_name.' started following You.',
                ]) : false;

            return true;
        }

        FavouriteCompany::where('user_id', $input['userId'])
            ->where('company_id', $input['companyId'])
            ->delete();

        return false;
    }

    /**
     * @param  array  $input
     *
     *
     * @return bool
     */
    public function storeReportToCompany($input)
    {
        $jobReportedAsAbuse = ReportedToCompany::where('user_id', $input['userId'])
            ->where('company_id', $input['companyId'])
            ->exists();

        if (! $jobReportedAsAbuse) {
            $reportedCompanyNote = trim($input['note']);
            if (empty($reportedCompanyNote)) {
                throw ValidationException::withMessages([
                    'note' => 'The Note Field is required',
                ]);
            }
            ReportedToCompany::create([
                'user_id' => $input['userId'],
                'company_id' => $input['companyId'],
                'note' => $input['note'],
            ]);

            return true;
        }

        FavouriteCompany::where('user_id', $input['userId'])
            ->where('company_id', $input['companyId'])
            ->delete();

        return true;
    }

    /**
     * @param $reportedToCompany
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getReportedToCompany($reportedToCompany)
    {
        $query = ReportedToCompany::with([
            'user', 'company.user',
        ])->select('reported_to_companies.*')->findOrFail($reportedToCompany);

        return $query;
    }

    public function get($input = [])
    {
        /** @var Company $query */
        $query = Company::with(['user' => function($query) {
            $query->without(['country', 'state', 'city']);
        }, 'activeFeatured'])->select('companies.*');

        $query->when(isset($input['is_featured']) && $input['is_featured'] == 1,
            function (Builder $q) use ($input) {
                $q->has('activeFeatured');
            });

        $query->when(isset($input['is_featured']) && $input['is_featured'] == 0,
            function (Builder $q) use ($input) {
                $q->doesnthave('activeFeatured');
            });

        $query->when(isset($input['is_status']) && $input['is_status'] == 1,
            function (Builder $q) use ($input) {
                $q->wherehas('user', function (Builder $q) {
                    $q->where('is_active', '=', 1);
                });
            });

        $query->when(isset($input['is_status']) && $input['is_status'] == 0,
            function (Builder $q) use ($input) {
                $q->wherehas('user', function (Builder $q) {
                    $q->where('is_active', '=', 0);
                });
            });

        $subQuery = $query->get();

        $result = $data = [];
        $subQuery->map(function (Company $company) use ($data, &$result) {
            if(!$company) {
                $data['id'] = $company->id;
                $data['user'] = [
                    'full_name' => $company->user->full_name,
                    'first_name' => $company->user->first_name,
                    'last_name' => $company->user->last_name,
                    'email' => $company->user->email,
                    'is_active' => $company->user->is_active,
                    'email_verified_at' => $company->user->email_verified_at,
                ];
                $data['company_url'] = $company->company_url;
                $data['active_featured'] = $company->activeFeatured;

                $result[] = $data;
            }
        });

        return $result;
    }

    public function softDelete(Company $objCompany)
    {
        $objCompany->setIsDeleted(true);

        if($objCompany->save()){
            return true;
        }

        return false;
    }
}
