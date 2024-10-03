<?php

namespace App\Application\User\UpdateUser;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $userId,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?array $roles,
    ) {
    }
}
