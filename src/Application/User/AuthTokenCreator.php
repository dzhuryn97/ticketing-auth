<?php

namespace App\Application\User;

use App\Domain\User\User;

class AuthTokenCreator
{
    public function __construct(
        private readonly TokenEncoder $tokenEncoder,
        private readonly AuthUserFactory $authUserFactory,
    ) {
    }

    public function createFromUser(User $user): string
    {
        $authUser = $this->authUserFactory->createFromUser($user);
        $payload = $authUser->toArray();

        return $this->tokenEncoder->encode($payload);
    }
}
