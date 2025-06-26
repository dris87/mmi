<?php

namespace App\Rules;

use App\Models\CompanyUser;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\CompanyUserFactory;
use App\Models\Factories\PermissionFactory;
use Illuminate\Contracts\Validation\Rule;

class CompanyUserAtleastOneAdmin implements Rule
{
    public $fields = null;
    public $companyUser = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(CompanyUser $objCompanyUser, $data)
    {
        $this->fields = $data;
        $this->companyUser = $objCompanyUser;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->companyUser->getPermissionId() != $this->fields['permission_id']) {
            $objPermission = (new PermissionFactory())->getFrontOfficeAdminPermission();
            $objCompany = (new CompanyFactory())->getById($this->companyUser->getCompanyId());
            $arrCompanyUsers = (new CompanyUserFactory())->getByCompanyAndPermission($objCompany, $objPermission, [$this->companyUser->getId()]);

            if ($arrCompanyUsers)
                return true;
            else
                return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('messages.coworker.delete_error_at_least_one_admin_required');
    }
}
