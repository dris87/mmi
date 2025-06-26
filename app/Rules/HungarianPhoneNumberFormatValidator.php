<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HungarianPhoneNumberFormatValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match(
            '/^((?:[03])6)?(?(?=([237]0|1))([237]0|1)(\d{7})|(2[2-9]|3[2-7]|4[024-9]|5[234679]|6[23689]|7[2-9]|8[02-9]|9[92-69])(\d{6}))$/',
            $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('messages.common.invalid_phone_number_format');
    }
}
