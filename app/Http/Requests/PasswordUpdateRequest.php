<?php

namespace App\Http\Requests;

use App\Models\EmailJob;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            'new_password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'new_password_confirmation' => 'required|same:new_password',
        ];
    }



    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'new_password.regex' => 'A jelszó minimum 6 karakter hosszúságúnak kell lennie, tartalmaznia kell kis- és nagybetűt illetve számot.',
        ];
    }
}
