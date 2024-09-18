<?php

namespace App\Application\Role\GetRole;

use App\Domain\Role\Exception\RoleNotFoundException;
use App\Domain\Role\RoleRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetRoleQueryHandler implements QueryHandlerInterface
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function __invoke(GetRoleQuery $query)
    {
        $role = $this->roleRepository->findById($query->roleId);
        if (!$role) {
            throw new RoleNotFoundException($query->roleId);
        }

        return $role;
    }
}
