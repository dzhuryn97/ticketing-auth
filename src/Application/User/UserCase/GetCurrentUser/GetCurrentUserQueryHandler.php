<?php

namespace App\Application\User\UserCase\GetCurrentUser;


use Ticketing\Common\Application\Security\AuthUserDto;
use Ticketing\Common\Application\Security\Security;

class GetCurrentUserQueryHandler
{

    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function handle():?AuthUserDto
    {
        return $this->security->connectedUser();
    }
}