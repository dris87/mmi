<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebRegisterRequest extends FormRequest
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
            'first_name'    => 'required',
            'email'         => 'required|email:filter|unique:users',
            'password'      => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
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
        ];
    }
}
