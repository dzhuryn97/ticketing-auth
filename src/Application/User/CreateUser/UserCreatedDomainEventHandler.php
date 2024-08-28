<?php

namespace App\Application\User\CreateUser;

use App\Domain\User\UserCreatedDomainEvent;
use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\User\UserCreatedIntegrationEvent;

class UserCreatedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly EventBusInterface $eventBus,
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function __invoke(UserCreatedDomainEvent $event)
    {
        $user = $this->userRepository->get($event->userId);

        $integrationEvent = new UserCreatedIntegrationEvent(
            $event->id,
            $event->occurredOn,
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
        );

        $this->eventBus->publish($integrationEvent);
    }
}