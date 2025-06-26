<?php

namespace App\Http\Requests\Backoffice;

use App\Lib\Backoffice\User\BackofficeUserRepository;
use App\Models\BackofficeUser;
use App\Models\Factories\BackofficeUserFactory;
use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ApplyJobRequest
 */
class CreateBackofficeUserRequest extends FormRequest
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

        $rules = BackofficeUser::$rules;

        $rules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone'             => ['required', new HungarianPhoneNumberFormatValidator()],
            'notified_name' => 'required|min:3',
            'notified_phone' => 'required',
            'dob' => 'required',
            'email' => 'required|email|unique:backoffice_users,email',
            'position_id' => 'required|exists:backoffice_positions,id',
            'superior_id' => 'required|exists:backoffice_users,id',
            'branch_office_id' => 'required|exists:branch_offices,id',
            'main_permission_id' => 'required|exists:permissions,id',
            'extra_permission_ids' => 'nullable|exists:permissions,id',
        ];

        if (is_string($this->backofficeUserModel)) {
            $rules['email'] = 'required|email|unique:backoffice_users,email,' . $this->backofficeUserModel;
        }

        if (is_object($this->backofficeUserModel)) {
            $rules['email'] = 'required|email|unique:backoffice_users,email,' . $this->backofficeUserModel->id;
        }

        if ($this->request->get('user_id')) {

            if(Auth::user()->id === intval($this->request->get('user_id'))){
                $objBackOfficeUser = (new BackofficeUserFactory())->getByUserId(Auth::user()->id);
            }

            $rules = [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'phone'             => ['required', new HungarianPhoneNumberFormatValidator()],
                'notified_name' => 'required|min:3',
                'notified_phone' => 'required',
                'dob' => 'required',
                'email' => 'required|email|unique:backoffice_users,email,'.$objBackOfficeUser->id,
            ];
        }

        return $rules;
    }
}
