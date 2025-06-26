<?php

namespace App\Http\Requests;

use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidateUpdateProfileRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if($this->request->get('user_id')){
            $id = $this->request->get('user_id');
        }else{
            $id = Auth::user()->id;
        }

        return [
            'first_name'        => 'required|max:180',
            'last_name'         => 'required|max:180',
            'able_to_travel_distance' => 'nullable|integer|min:10|max:150',
            'expected_salary' => 'nullable|required_with:expected_salary_to|integer|lte:expected_salary_to',
            'expected_salary_to' => 'nullable|required_with:expected_salary|integer|gte:expected_salary',
            'candidate_status_id'=>'required|integer',
            'gender'            => 'required',
            'dob'               => 'required|date',
            'phone'             => ['required', new HungarianPhoneNumberFormatValidator()],
            'zipCode'           => 'required|numeric|exists:postal_codes,postal_code'
        ];
    }

}
