<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64ImageValidationRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exploded = explode(',', $value);
        $allow = ['png', 'jpg', 'jpeg', 'gif'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $exploded[0]
        );

        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }

        // check base64 string is valid or not
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $exploded[1])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a base64 encoded image.';
    }
}
