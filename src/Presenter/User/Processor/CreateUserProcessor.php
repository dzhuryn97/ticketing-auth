<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use App\Application\User\UserCase\CreateUser\CreateUserCommand;
use App\Application\User\UserCase\CreateUser\CreateUserCommandHandler;
use App\Presenter\Role\RoleResource;
use App\Presenter\User\Resource\UserResource;
use Ticketing\Common\Domain\Exception\ValidationFailed;

class CreateUserProcessor implements ProcessorInterface
{
    private CreateUserCommandHandler $createUserHandler;

    public function __construct(
        CreateUserCommandHandler $createUserHandler
    )
    {
        $this->createUserHandler = $createUserHandler;
    }

    /**
     * @param UserResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new CreateUserCommand(
            email: $data->email,
            name: $data->name,
            password: $data->password,
            roles: array_map(function (RoleResource $roleResource){
                return $roleResource->id;
            },$data->roles)
        );

        $user = $this->createUserHandler->handle($command);
//        try {
//        $user = $this->createUserHandler->handle($command);
//        } catch (ValidationFailed $exception) {
//            throw new ValidationException($exception->getMessage(), 400);
//        }

        return UserResource::fromUser($user);
    }
}