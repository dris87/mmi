<?php


namespace App\Models\Factories;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CompanyFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Company::class;
    }


    /**
     * @param $job_id
     * @return mixed
     */
    public function getByJob(Job $objJob)
    {
        return $this->model::where('id', '=', $objJob->getCompanyId())->get();
    }

    /**
     * @param $job_id
     * @return mixed
     */
    public function getByUser(User $objUser)
    {
        return $this->model::where('user_id', '=', $objUser->getId())->get();
    }

    /**
     * @param $job_id
     * @return mixed
     */
    public function getObjByUser(User $objUser)
    {
        return $this->model::where('user_id', '=', $objUser->getId())->first();
    }

    /**
     * @throws \Exception
     */
    public function getAllFormatted()
    {
        $companies = Company::query()->select(
            "companies.id as id",
            "companies.name",
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS contact_name"),
            "users.email",
            "users.phone as phone",
            "company_users.phone as contact_person_phone",
            "users.email as email",
            "users.is_active",
        )->leftJoin("users", "users.id", "=", "companies.user_id")
            ->leftJoin("company_users", "company_users.user_id", "=", "users.id")
            ->where('users.is_deleted', '=', 0)
            ->get();

        $activityLogFactory = new ActivityLogFactory();

        foreach($companies as $company){
            $objActivity = $activityLogFactory->getLatestByCompanyId($company->id);
            $company->latest_activity = $objActivity ? date('Y-m-d', strtotime($objActivity->getCreatedAt())) : '-';
            $company->status = $company->is_active == 1 ? trans('messages.common.active') : trans('messages.common.de_active');
            $company->support = '-';
        }

        return $companies;
    }

}
