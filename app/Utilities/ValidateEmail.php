<?php

namespace App\Utilities;

class ValidateEmail
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle email address validation.
     *
     * @return bool
     */
    public function handleValidateEmail(string $email): bool
    {
        $getDomainFromEmail = substr(strstr($email, '@'), 1);
        escapeshellcmd(exec('ping ' . escapeshellarg($getDomainFromEmail), $output, $value));
        if ($value === 1 || $value === 2)
        {
            return false;
        } else {
            return true;
        }
    }
}
