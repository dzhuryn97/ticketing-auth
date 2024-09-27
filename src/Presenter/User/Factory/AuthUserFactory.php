<?php

namespace App\Presenter\User\Factory;

use App\Domain\User\User;
use Ticketing\Common\Presenter\Symfony\Security\AuthUser;

class AuthUserFactory
{
    public function createFromUser(User $user): AuthUser
    {
        return new AuthUser(
            $user->getId(),
            $user->getName(),
            $user->getPermissions()
        );
    }
}
