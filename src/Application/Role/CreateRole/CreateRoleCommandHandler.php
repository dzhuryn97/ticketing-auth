<?php

namespace App\Application\Role\CreateRole;

use App\Domain\Role\Role;
use App\Domain\Role\RoleRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateRoleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
    ) {
    }

    public function __invoke(CreateRoleCommand $command)
    {
        $role = new Role(
            $command->name,
            $command->permissions
        );

        $this->roleRepository->add($role);

        return $role->getId();
    }
}
