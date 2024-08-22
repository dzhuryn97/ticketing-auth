<?php

namespace App\Application\Role\UpdateRole;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class UpdateRoleCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $roleId,
        public readonly string $name,
        public readonly array $permissions
    )
    {
    }
}