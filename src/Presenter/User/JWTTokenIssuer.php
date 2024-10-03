<?php

namespace App\Presenter\User;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ticketing\Common\Presenter\Symfony\Security\AuthUser;

class JWTTokenIssuer
{
    public function __construct(
        private readonly JWTTokenManagerInterface $JWTManager,
    ) {
    }

    public function issueToken(AuthUser $authUser)
    {
        return $this->JWTManager->createFromPayload($authUser, [
            'name' => $authUser->getName(),
        ]);
    }
}
