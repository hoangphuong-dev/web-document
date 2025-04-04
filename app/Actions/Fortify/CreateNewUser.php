<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\User\AuthService;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        return AuthService::createNewUser($input);
    }
}
