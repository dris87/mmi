<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateRequest extends FormRequest
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
        $rules = Candidate::$rules;
        if(empty($this->route('candidate'))){
            $user = \Illuminate\Support\Facades\Auth::user();
            $rules['email'] = 'required|email:filter|unique:users,email,'.$user->id;
        }else{
            $rules['email'] = 'required|email:filter|unique:users,email,'.$this->route('candidate')->user->id;
        }
        $rules['phone'] = ['required', new HungarianPhoneNumberFormatValidator()];

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json($validator->errors());
    }


    public function messages()
    {
        return CreateCandidateRequest::_messages();
    }
}
