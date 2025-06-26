<?php


namespace App\Models\Factories;

use App\Models\ActivityLog;
use App\Models\Candidate;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\State;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class ActivityLogFactory extends BaseFactory
{

    public function __construct()
    {
        $this->model = ActivityLog::class;
    }

    public function getAllFormatted()
    {
        return ActivityLog::query()->select(
            "activity_log.id",
            "activity_log.log_name",
            "activity_log.description",
            "activity_log.subject_type",
            "activity_log.subject_id",
            DB::raw("DATE_FORMAT(activity_log.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(activity_log.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS causer_user"),
        )->leftJoin("users", "users.id", "=", "activity_log.causer_id")
                ->whereRaw('
            log_name = "custom"')
            ->get();
    }

    public function getAllByCandidateFormatted(Candidate $objCandidate)
    {
        $user_id = $objCandidate->user_id;

        return ActivityLog::query()->select(
            "activity_log.id",
            "activity_log.log_name",
            "activity_log.description",
            "activity_log.subject_type",
            "activity_log.properties",
            DB::raw("DATE_FORMAT(activity_log.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(activity_log.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS causer_user"),
        )
            ->leftJoin("users", "users.id", "=", "activity_log.causer_id")
            ->whereRaw('
            log_name = "custom" and
            ((subject_type = ? and subject_id = ? )
            or
            (subject_type = ? and subject_id = ? ))', ["App\Models\User",$user_id,"App\Models\Candidate",$objCandidate->id])
            ->get();
    }

    public function getByLogName($logname)
    {
        return $this->model::where("log_name", $logname)->first();
    }

    public function getLastByCauser(User $objUser)
    {
        return $this->model::where("causer_id", $objUser->getId())->orderByDesc("created_at")->first();
    }
    public function getLatestByCauserId($id)
    {
        return $this->model::where("causer_id", $id)->orderBy("created_at", 'desc')->first();
    }
    public function getByModel($Class)
    {
        return $this->model::where("subject_type", $Class->getId())->first();
    }

    public function getLatestByCompanyId($id)
    {
        $objUser = (new UserFactory())->getByCompanyId($id);
        $arrCompanyUsers = (new CompanyUserFactory())->getByCompanyId($id);

        if (!$objUser) {
            throw new Exception('The specified user does not exist');
        }

        $arrIds = [];
        $arrIds[] = $objUser->getId();

        if ($arrCompanyUsers) {
            foreach ($arrCompanyUsers as $objCompanyUser){
                $arrIds[] = $objCompanyUser->getId();
            }
        }

        return ActivityLog::query()->whereIn('causer_id', $arrIds)->where('log_name', 'custom')->orderBy("created_at", 'desc')->first();
    }

    public function getAllByCompanyFormatted(Company $objCompany)
    {
        $objUser = (new UserFactory())->getByCompanyId($objCompany->id);
        $arrCompanyUsers = (new CompanyUserFactory())->getByCompanyId($objCompany->id);
        if (!$objUser) {
            throw new Exception('The specified user does not exist');
        }

        $arrIds = [];
        $arrIds[] = $objUser->getId();

        if ($arrCompanyUsers) {
            foreach ($arrCompanyUsers as $objCompanyUser){
                $arrIds[] = $objCompanyUser->getUserId();
            }
        }

        $query = ActivityLog::query()->select(
            "activity_log.id",
            "activity_log.log_name",
            "activity_log.description",
            "activity_log.subject_type",
            "activity_log.properties",
            DB::raw("DATE_FORMAT(activity_log.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(activity_log.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS causer_user"),
        )
            ->join("users", "users.id", "=", "activity_log.causer_id")
            ->where('activity_log.log_name', 'custom')
            ->where(function ($q) use($arrIds, $objCompany) {
                $q->whereIn('activity_log.causer_id', $arrIds);
                $q->orWhereRaw(" ( activity_log.subject_id = ".$objCompany->getId()." and subject_type = 'App\\\Models\\\Company' )");
            })
            ->orderByDesc('activity_log.created_at');

        return  $query->get()->all();
    }
}


