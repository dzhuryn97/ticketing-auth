<?php

namespace App\Domain\Role\Exception;

use App\Domain\Role\Role;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class RoleNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $roleId)
    {
        parent::__construct($roleId, Role::class);
    }
}
