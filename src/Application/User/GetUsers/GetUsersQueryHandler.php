<?php

namespace App\Application\User\GetUsers;

use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function __invoke(GetUsersQuery $query)
    {
        return $this->userRepository->getAll();
    }
}