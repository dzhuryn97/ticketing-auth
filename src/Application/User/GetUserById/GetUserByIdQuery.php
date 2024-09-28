<?php

namespace App\Application\User\GetUserById;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

final class GetUserByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $userId,
    ) {
    }
}
