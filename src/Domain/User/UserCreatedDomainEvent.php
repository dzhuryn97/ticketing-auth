<?php

namespace App\Domain\User;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class UserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $userId,
    ) {
        parent::__construct();
    }
}
