<?php

namespace App\Application\User\Login;

use App\Domain\User\User;
use Ticketing\Common\Application\Command\CommandInterface;

/**
 * @implements CommandInterface<User>
 */
class LoginUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    )
    {
    }
}