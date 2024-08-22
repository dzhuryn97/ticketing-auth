<?php

declare(strict_types=1);

namespace App\Application\User\UserCase\GetUserById;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

final class GetUserByIdQueryHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }


    public function handle(GetUserByIdQuery $query): ?User
    {
        return $this->userRepository->get($query->userId);

    }
}
