<?php

namespace App\Application\Role\UpdateRole;

use App\Domain\Role\Exception\RoleNotFoundException;
use App\Domain\Role\RoleRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class UpdateRoleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
    ) {
    }

    public function __invoke(UpdateRoleCommand $command)
    {
        $role = $this->roleRepository->findById($command->roleId);
        if (!$role) {
            throw new RoleNotFoundException($command->roleId);
        }

        $role->update(
            $command->name,
            $command->permissions
        );

        $this->roleRepository->save($role);
    }
}
