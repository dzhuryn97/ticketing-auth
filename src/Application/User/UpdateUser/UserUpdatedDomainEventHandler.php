<?php

namespace App\Application\User\UpdateUser;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserUpdatedDomainEvent;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\User\UserUpdatedIntegrationEvent;

class UserUpdatedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly  UserRepositoryInterface $userRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(UserUpdatedDomainEvent $event)
    {
        $user = $this->userRepository->get($event->userId);

        $integrationEvent = new UserUpdatedIntegrationEvent(
            $event->id,
            $event->occurredOn,
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
        );

        $this->eventBus->publish($integrationEvent);
    }
}
