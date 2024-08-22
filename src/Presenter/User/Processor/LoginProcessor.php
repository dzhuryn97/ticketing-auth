<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\UserCase\Login\LoginUserCommand;
use App\Application\User\UserCase\Login\LoginUserHandler;
use App\Presenter\User\Output\JWT;
use App\Presenter\User\Payload\Login;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ticketing\Common\Presenter\Symfony\Security\AuthUser;

class LoginProcessor implements ProcessorInterface
{


    public function __construct(
        private readonly LoginUserHandler $loginHandler,
        private readonly JWTTokenManagerInterface $JWTManager
    )
    {
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
        $user = $this->loginHandler->handle($command);


        $authUser = new AuthUser(
            $user->getId(),
            $user->getEmail(),
            $user->getRoles()

        );

        $token = $this->JWTManager->create($authUser);


        return new JWT($token);
    }
}