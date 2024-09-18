<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\Login\LoginUserCommand;
use App\Presenter\User\Output\JWT;
use App\Presenter\User\Payload\Login;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Presenter\Symfony\Security\AuthUser;

class LoginProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly JWTTokenManagerInterface $JWTManager,
    ) {
    }

    /**
     * @param Login $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new LoginUserCommand(
            $data->email,
            $data->password,
        );
        $user = $this->commandBus->dispatch($command);


        $authUser = new AuthUser(
            $user->getId(),
            $user->getPermissions()
        );

        $token = $this->JWTManager->create($authUser);


        return new JWT($token);
    }
}
