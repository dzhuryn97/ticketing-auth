<?php

namespace App\Domain\User\Exception;

class EmailIsUsedException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('Email isn\'t unique'));
    }
}
