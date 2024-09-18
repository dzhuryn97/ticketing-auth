<?php

namespace App\Application\Role\GetRole;

use App\Domain\Role\Role;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<Role>
 */
class GetRoleQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $roleId,
    ) {
    }
}
