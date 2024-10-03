<?php

namespace App\Presenter\User\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\User\GetCurrentUser\GetCurrentUserQuery;
use App\Presenter\User\Output\AuthUserOutput;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Ticketing\Common\Application\Query\QueryBusInterface;

class AuthenticationProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $authUserDto = $this->queryBus->ask(new GetCurrentUserQuery());

        if (!$authUserDto) {
            throw new AuthenticationException();
        }

        return AuthUserOutput::fromAuthUserDto($authUserDto);
    }
}
