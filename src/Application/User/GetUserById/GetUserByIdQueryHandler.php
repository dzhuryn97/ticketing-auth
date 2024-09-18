<?php

declare(strict_types=1);

namespace App\Application\User\GetUserById;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

final class GetUserByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUserByIdQuery $query): ?User
    {
        return $this->userRepository->get($query->userId);

    }
}
