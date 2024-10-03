<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\GetUserById\GetUserByIdQuery;
use App\Application\User\UpdateUser\UpdateUserCommand;
use App\Presenter\Role\RoleResource;
use App\Presenter\User\Resource\UserResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class UpdateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @param UserResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $userId = $uriVariables['id'];
        $command = new UpdateUserCommand(
            userId: $userId,
            name: $data->name,
            email: $data->email,
            password: $data->password,
            roles: $data->roles ? array_map(function (RoleResource $roleResource) {
                return $roleResource->id;
            }, $data->roles) : null
        );

        $this->commandBus->dispatch($command);

        $user = $this->queryBus->ask(new GetUserByIdQuery($userId));

        return UserResource::fromUser($user);
    }
}
