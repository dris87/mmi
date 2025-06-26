<?php

namespace App\Http\Requests;

use App\Rules\HungarianPhoneNumberFormatValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterRequest extends FormRequest
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
        return [
            'vatNumber' => 'required|unique:companies,vatNumber',
            'companyName'    => 'required',
            'zipCode' => 'required|numeric|exists:postal_codes,postal_code',
            'city'    => 'required|exists:cities,name',
            'houseNumber'    => 'required',
            'street'    => 'required',
            'firstName'    => 'required',
            'lastName'    => 'required',
            'position_id'    => 'required|exists:positions,id',
            'representative' => 'required',
            'phone'    => ['required', new HungarianPhoneNumberFormatValidator()],
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
            'privacyPolicy' => 'required',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'privacyPolicy.required' => 'A regisztráció folytatásához kérjük, fogadja el az Általános Szerződési Feltételeket és az Adatvédelmi nyilatkozatot.',
            'password.regex' => 'A jelszó minimum 6 karakter hosszúságúnak kell lennie, tartalmaznia kell kis- és nagybetűt illetve számot.',
            'email.email' => 'Helytelen e-mail cím formátum. Helyes formátum email@cim.hu',
            'email.unique' => 'Az e-mail cím már használatban van.',
            'vatNumber.unique' => 'Az adószámot már regisztrálták. Amennyiben nem Ön regisztrálta a céget, kérjük vegye fel velünk a kapcsolatot.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response()->json($validator->errors());
    }
}
