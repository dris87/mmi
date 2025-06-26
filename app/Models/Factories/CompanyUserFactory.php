<?php


namespace App\Models\Factories;

use App\Helpers\UserHelper;
use App\Models\Company;
use App\Models\CompanySite;
use App\Models\CompanyUser;
use App\Models\CoworkerPosition;
use App\Models\Permission;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CompanyUserFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CompanyUser::class;
    }


    /**
     * @param Company $objCompany
     * @param array $excludedCompanyUserIds
     * @return mixed
     */
    public function getByCompany(Company $objCompany, array $excludedCompanyUserIds = array())
    {
        $objBuilder = $this->model::where('company_id', '=', $objCompany->id);
        if($excludedCompanyUserIds){
            $objBuilder->whereNotIn('id', $excludedCompanyUserIds);
        }
        return $objBuilder->get()->all();
    }

    /**
     * @param Company $objCompany
     * @param Permission $objPermission
     * @param array $excludedCompanyUserIds
     * @return mixed
     */
    public function getByCompanyAndPermission(Company $objCompany, Permission $objPermission, array $excludedCompanyUserIds = array()){
        $objBuilder = $this->model::where('company_id', '=', $objCompany->id)
            ->where('permission_id', '=', $objPermission->getId());
        if($excludedCompanyUserIds){
            $objBuilder->whereNotIn('id', $excludedCompanyUserIds);
        }
        $objBuilder->where('is_active', '=', 1);
        return $objBuilder->get()->all();
    }

    /**
     * @param $objUser
     * @param Company $objCompany
     * @return mixed
     */
    public function getByUserAndCompany($objUser, Company $objCompany)
    {
        return $this->model::where('company_id', '=', $objCompany->id)->where('user_id', '=', $objUser->id)->first();
    }

    /**
     * @param Company $objCompany
     * @return mixed
     */
    public function getByCompanyFormatted(Company $objCompany)
    {
        $arrCompanyUsers =  $this->model::query()
            ->select("company_users.id as id",
                DB::raw("CONCAT(users.first_name,' ',users.last_name) AS contact_name"),
                "users.last_login as last_login",
                "coworker_positions.name as position",
                "cities.name as site",
                DB::raw("CONCAT(postal_codes.postal_code,' ',cities.name,' ', company_sites.street,' ', company_sites.address,' ', company_sites.floor,' ', company_sites.door) AS site"),
                "permissions.name as role",
                "company_users.is_active as is_active",
                "company_users.phone as phone",
                "users.email as email",
            )
            ->leftJoin("users", "users.id", "=", "company_users.user_id")
            ->leftJoin("company_sites", "company_users.company_site_id", "=", "company_sites.id")
            ->leftJoin("coworker_positions", "company_users.coworker_position_id", "=", "coworker_positions.id")
            ->leftJoin("permissions", "company_users.permission_id", "=", "permissions.id")
            ->leftJoin("cities", "company_sites.city_id", "=", "cities.id")
            ->leftJoin("postal_codes", "company_sites.postcode_id", "=", "postal_codes.id")
            ->where('users.is_deleted', '=', 0)
            ->where('company_users.company_id', '=', $objCompany->id)->get()->all();

        foreach($arrCompanyUsers as $companyUser){
            $companyUser->status = $companyUser->is_active == 1 ? trans('messages.common.active') : trans('messages.common.de_active');
        }

        return $arrCompanyUsers;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getByCompanyId($id)
    {
        return $this->model::where('company_id', '=', $id)->get()->all();
    }


    /**
     * @param User $objUser
     * @param Company $objCompany
     * @param Permission $objPermission
     * @param CoworkerPosition $objCoworkerPosition
     * @param string $phone
     * @param CompanySite|null $objCompanySite
     * @return CompanyUser
     * @throws Exception
     */
    public function create(User $objUser, Company $objCompany, Permission $objPermission, CoworkerPosition $objCoworkerPosition, string $phone, CompanySite $objCompanySite = null){

        $objCreatedByUser = UserHelper::getCurrentUser();

        $objCompanyUser = new CompanyUser();
        $objCompanyUser->setUserId($objUser->getId());
        $objCompanyUser->setCompanyId($objCompany->getId());

        if($objCreatedByUser) {
            $objCompanyUser->setCreatedBy($objCreatedByUser->getId());
        }

        $objCompanyUser->setPermissionId($objPermission->getId());

        $objCompanyUser->setCoworkerPositionId($objCoworkerPosition->getId());
        $objCompanyUser->setPhone($phone);

        if($objCompanySite){
            $objCompanyUser->setCompanySiteId($objCompanySite->getId());
        }

        if(!$objCompanyUser->save()){
            throw new Exception('There was an error saving the company user');
        }

        return $objCompanyUser;
    }

    /**
     * @param CompanyUser $objCompanyUser
     * @param User $objUser
     * @param Company $objCompany
     * @param Permission $objPermission
     * @param CoworkerPosition $objCoworkerPosition
     * @param string $phone
     * @param int $isActive
     * @param CompanySite|null $objCompanySite
     * @return CompanyUser
     * @throws Exception
     */
    public function update(CompanyUser $objCompanyUser, User $objUser, Company $objCompany, Permission $objPermission, CoworkerPosition $objCoworkerPosition, string $phone, int $isActive = 1, CompanySite $objCompanySite = null){

        $objCompanyUser->setUserId($objUser->getId());
        $objCompanyUser->setCompanyId($objCompany->getId());
        $objCompanyUser->setPermissionId($objPermission->getId());
        $objCompanyUser->setCoworkerPositionId($objCoworkerPosition->getId());
        $objCompanyUser->setPhone($phone);

        if($objCompanySite){
            $objCompanyUser->setCompanySiteId($objCompanySite->getId());
        }
        else{
            $objCompanyUser->setCompanySiteId(null);
        }

        $objCompanyUser->setIsActive($isActive);

        if(!$objCompanyUser->save()){
            throw new Exception('There was an error saving the company user');
        }

        return $objCompanyUser;
    }

    /**
     * @param CompanyUser $objCompanyUser
     * @return bool
     */
    public function delete(CompanyUser $objCompanyUser)
    {
        if($objCompanyUser->delete()){
            return true;
        }
        return false;
    }

    /**
     * @param CompanyUser $objCompanyUser
     * @param $status
     * @return CompanyUser|false
     */
    public function changeStatus(CompanyUser $objCompanyUser, $status){

        $objCompanyUser->setIsActive((bool)$status);
        if(!$objCompanyUser->save()){
            return false;
        }
        return $objCompanyUser;
    }

}
