<?php

namespace App\Application\User\GetUserById;

use App\Domain\User\Exception\UserNotFoundException;
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
        $user =  $this->userRepository->findById($query->userId);
        if (!$user) {
            throw new UserNotFoundException($query->userId);
        }

        return $user;
    }
}
