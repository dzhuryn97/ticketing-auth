<?php

namespace App\Presenter\User\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\Login\LoginUserCommand;
use App\Presenter\User\Factory\AuthUserFactory;
use App\Presenter\User\JWTTokenIssuer;
use App\Presenter\User\Output\JWT;
use App\Presenter\User\Payload\Login;
use Ticketing\Common\Application\Command\CommandBusInterface;

class LoginProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly AuthUserFactory $authUserFactory,
        private readonly JWTTokenIssuer $JWTTokenIssuer,
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

        $authUser = $this->authUserFactory->createFromUser($user);
        $jwtToken = $this->JWTTokenIssuer->issueToken($authUser);

        return new JWT($jwtToken);
    }
}
