<?php

namespace App\Domain\User\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class EmailIsUsedException extends BusinessException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('Email %s already used', $email), 'EmailIsUsed');
    }
}
