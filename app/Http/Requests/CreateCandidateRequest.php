<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateCandidateRequest extends FormRequest
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
//        $currentSalary = removeCommaFromNumbers($this->request->get('current_salary'));
//        $expectedSalary = removeCommaFromNumbers($this->request->get('expected_salary'));
//
//        $this->request->set('current_salary', $currentSalary);
//        $this->request->set('expected_salary', $expectedSalary);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  Candidate::$rules;
        $rules['phone'] = ['required', new HungarianPhoneNumberFormatValidator()];
        return  $rules;
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json($validator->errors());
    }

    public static function _messages()
    {
        return [
            'first_name.required'        => 'A keresztnév megadása kötelező!',
            'last_name.required'         => 'A vezetéknév megadása kötelező!',
            'nationality.required'       => 'A nemzetiség megadása kötelező!',
            'email.required'             => 'Az email cím megadása kötelező!',
            'password.required'          => 'A jelszó megadása kötelező!6',
            'password.regex' => 'A jelszó minimum 6 karakter hosszúságúnak kell lennie, tartalmaznia kell kis- és nagybetűt illetve számot.',
            'gender.required'            => 'A nem megadása kötelező!',
            'dob.required'               => 'A születési dátum megadása kötelező!',
            'phone.required'             => 'A telefonszám megadása kötelező!',
            'zipCode.required'           => 'A irányítószám megadása kötelező!',
            'city.required'              => 'A település megadása kötelező!',
            'able_to_travel_distance:min'=>"A utázasi hajlandóság értéke nem lehet kisebb, mint 10!",
            'able_to_travel_distance:max'=>"A utázasi hajlandóság értéke nem lehet nagyobb, mint 150!"
        ];
    }

    public function messages()
    {
       return Self::_messages();
    }
}
