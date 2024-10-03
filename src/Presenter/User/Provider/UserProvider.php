<?php

namespace App\Presenter\User\Provider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\User\GetUserById\GetUserByIdQuery;
use App\Application\User\GetUsers\GetUsersQuery;
use App\Domain\User\User;
use App\Presenter\User\Resource\UserResource;
use Ticketing\Common\Application\Query\QueryBusInterface;

class UserProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            $userId = $uriVariables['id'];
            $user = $this->queryBus->ask(new GetUserByIdQuery($userId));

            return UserResource::fromUser($user);
        }


        $users = $this->queryBus->ask(new GetUsersQuery());

        return array_map(function (User $user) {
            return  UserResource::fromUser($user);

        }, $users);
    }
}
