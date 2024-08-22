<?php

declare(strict_types=1);

namespace App\Application\User\UserCase\GetUserById;

final class GetUserByIdQuery
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
