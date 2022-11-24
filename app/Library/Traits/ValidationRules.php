<?php

namespace App\Library\Traits;

use App\Actions\Fortify\PasswordValidationRules;

trait ValidationRules
{
    use PasswordValidationRules;

    public function user(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ];
    }

    public function app(): array
    {
        return [
            'domain' => ['required', 'string', 'max:30', 'unique:domain'],
        ];
    }
}
