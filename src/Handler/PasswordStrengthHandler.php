<?php

namespace App\Handler;

class PasswordStrengthHandler
{
    private const REGEX_FORBIDDEN_CHARS = '/[äöüÄÖÜß\'"]/u';

    /** @var array */
    private $errors = [];

    /**
     * @param $value
     */
    public function validate($value): array
    {
        if (preg_match(self::REGEX_FORBIDDEN_CHARS, $value)) {
            $this->errors[] = 'form.forbidden_char';
        }

        if (strlen($value) < 12) {
            $this->errors[] = 'form.weak_password';
        }

        return $this->errors;
    }
}
