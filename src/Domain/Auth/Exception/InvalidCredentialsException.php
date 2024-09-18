<?php

namespace App\Domain\Auth\Exception;

class InvalidCredentialsException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Credentials invalid');
    }
}
