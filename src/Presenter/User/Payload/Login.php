<?php

namespace App\Presenter\User\Payload;

class Login
{
    public function __construct(
        public readonly string $email = '',
        public readonly string $password = '',
    ) {
    }
}
