<?php

namespace App\Presenter\Role\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Role\CreateRole\CreateRoleCommand;
use App\Application\Role\GetRole\GetRoleQuery;
use App\Presenter\Role\RoleResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class CreateRoleProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus
    )
    {
    }

    /**
     * @param RoleResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $roleId = $this->commandBus->dispatch(
            new CreateRoleCommand(
                $data->name,
                $data->permissions,
            )
        );
        $role = $this->queryBus->ask(
            new GetRoleQuery($roleId)
        );
        return RoleResource::createFromRole($role);
    }
}