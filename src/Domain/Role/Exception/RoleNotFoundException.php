<?php

namespace App\Domain\Role\Exception;

use Ramsey\Uuid\UuidInterface;

class RoleNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $roleId)
    {
        parent::__construct(sprintf('Role with identifier %s not found', $roleId));
    }
}
