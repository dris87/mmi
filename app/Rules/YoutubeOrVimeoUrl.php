<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class YoutubeOrVimeoUrl implements Rule
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
            '/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|channels\/(?:\w+\/)|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/',
            $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('messages.common.invalid_video_url_format');
    }
}
