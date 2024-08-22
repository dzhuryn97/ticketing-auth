<?php

namespace App\Presenter\User\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\User\UserCase\GetUserById\GetUserByIdQuery;
use App\Application\User\UserCase\GetUserById\GetUserByIdQueryHandler;
use App\Domain\User\Exception\UserEntityNotFoundException;
use App\Presenter\User\Resource\UserResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserProvider implements ProviderInterface
{
    private GetUserByIdQueryHandler $userByIdQueryHandler;

    public function __construct(
        GetUserByIdQueryHandler $getUserByIdQueryHandler
    )
    {
        $this->userByIdQueryHandler = $getUserByIdQueryHandler;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            $userId = (string)$uriVariables['id'];
            $userByIdQuery = new GetUserByIdQuery($userId);
            $user = $this->userByIdQueryHandler->handle($userByIdQuery);
        } catch (UserEntityNotFoundException $e){
            throw new NotFoundHttpException();
        }

        return  UserResource::fromUser($user);
    }
}