<?php

namespace App\Application\Role\GetRoles;

use App\Domain\Role\RoleRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetRolesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
    ) {
    }

    public function __invoke(GetRolesQuery $query)
    {
        return $this->roleRepository->all();
    }
}
