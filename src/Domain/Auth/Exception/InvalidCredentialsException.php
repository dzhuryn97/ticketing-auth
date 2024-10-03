<?php

namespace App\Domain\Auth\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class InvalidCredentialsException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('Credentials invalid', 'InvalidCredentials');
    }
}
