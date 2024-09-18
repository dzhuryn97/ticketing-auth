<?php

namespace App\Application\Role\CreateRole;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

/**
 * @implements CommandInterface<UuidInterface>
 */
class CreateRoleCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly array $permissions,
    ) {
    }
}
