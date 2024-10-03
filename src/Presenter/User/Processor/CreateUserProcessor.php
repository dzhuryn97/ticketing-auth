<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\CreateUser\CreateUserCommand;
use App\Presenter\Role\RoleResource;
use App\Presenter\User\Resource\UserResource;
use Ticketing\Common\Application\Command\CommandBusInterface;

class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param UserResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new CreateUserCommand(
            name: $data->name,
            email: $data->email,
            password: $data->password,
            roles: array_map(function (RoleResource $roleResource) {
                return $roleResource->id;
            }, $data->roles ?? [])
        );

        $user = $this->commandBus->dispatch($command);

        return UserResource::fromUser($user);
    }
}
