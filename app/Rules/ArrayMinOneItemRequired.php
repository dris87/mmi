<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayMinOneItemRequired implements Rule
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
        dump($value);
        die();
        foreach ($value as $arrayElement) {
            if (null !== $arrayElement) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('array_min_one_item_required');
    }
}
