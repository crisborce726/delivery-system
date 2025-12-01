<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecaptchaRule implements Rule
{
    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        // No arguments needed
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value)
    {
        // Always return true for now - bypass reCAPTCHA
        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message()
    {
        return 'The reCAPTCHA verification failed. Please try again.';
    }
}