<?php

namespace App\Presenter\Role;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Role\GetRole\GetRoleQuery;
use App\Application\Role\GetRoles\GetRolesQuery;
use App\Domain\Role\Role;
use Ticketing\Common\Application\Query\QueryBusInterface;

class RoleStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            $id = $uriVariables['id'];
            $role = $this->queryBus->ask(
                new GetRoleQuery($id)
            );

            return RoleResource::createFromRole($role);
        }

        $roles = $this->queryBus->ask(
            new GetRolesQuery()
        );

        return array_map(function (Role $role) {
            return RoleResource::createFromRole($role);
        }, $roles);
    }
}
