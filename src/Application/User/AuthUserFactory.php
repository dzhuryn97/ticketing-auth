<?php

namespace App\Application\User;

use App\Domain\User\User;
use Ticketing\Common\Application\Security\AuthUserDto;

class AuthUserFactory
{
    public function createFromUser(User $user): AuthUserDto
    {
        return new AuthUserDto(
            $user->getId(),
            $user->getName()
        );
    }
}