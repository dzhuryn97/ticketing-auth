<?php

namespace App\Application\User\GetCurrentUser;

use Ticketing\Common\Application\Query\QueryHandlerInterface;
use Ticketing\Common\Application\Security\AuthUserDto;
use Ticketing\Common\Application\Security\Security;

class GetCurrentUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function __invoke(GetCurrentUserQuery $query): ?AuthUserDto
    {
        return $this->security->connectedUser();
    }
}
