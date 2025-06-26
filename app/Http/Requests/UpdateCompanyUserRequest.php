<?php

namespace App\Http\Requests;

use App\Models\CompanyUser;
use App\Models\Factories\CompanyUserFactory;
use App\Models\Factories\UserFactory;
use App\Rules\CompanyUserAtleastOneAdmin;
use App\Rules\CompanyUserAtleastOneAdminActive;
use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $coworker_id = $this->route('companyUserId');

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['required', new HungarianPhoneNumberFormatValidator()],
            'company_site_id' => 'nullable|exists:company_sites,id',
            'position_id' => 'required|exists:coworker_positions,id',
        ];

        if($coworker_id) {

            $objCompanyUser = (new CompanyUserFactory())->getById($coworker_id);
            $objUser = (new UserFactory())->getById($objCompanyUser->getUserId());

            $rules['email'] = ['required', 'email:filter', Rule::unique('users', 'email')->ignoreModel($objUser)];
            $rules['permission_id'] = ['required', 'exists:permissions,id', new CompanyUserAtleastOneAdmin($objCompanyUser, $this->all())];
            $rules['is_active'] = ['required', new CompanyUserAtleastOneAdminActive($objCompanyUser, $this->all())];

        }
        else{
            $rules['email'] = ['required', 'email:filter'];
            $rules['permission_id'] = ['required', 'exists:permissions,id'];
            $rules['is_active'] = ['required'];
        }

        return $rules;
    }
}
