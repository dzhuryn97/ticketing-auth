<?php

namespace App\Application\User\CreateUser;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    /**
     * @param array<UuidInterface> $roles
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly array $roles,
    ) {
    }
}
