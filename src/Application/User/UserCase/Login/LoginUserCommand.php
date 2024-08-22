<?php

namespace App\Application\User\UserCase\Login;

class LoginUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    )
    {
    }
}