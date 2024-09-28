<?php

namespace App\Application\User\UpdateUser;

use App\Domain\Role\Role;
use App\Domain\Role\RoleRepositoryInterface;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository,
    ) {
    }

    public function __invoke(UpdateUserCommand $command)
    {
        $user = $this->userRepository->findById($command->userId);
        if (!$user) {
            throw new UserNotFoundException($command->userId);
        }

        $roles = $this->resolveRoles($command->roles);

        $user->update(
            $command->name,
            $command->email,
            $command->password,
            $roles,
        );

        $this->userRepository->save($user);
    }

    /**
     * @return Role[]|null
     */
    private function resolveRoles(?array $inputRoles): ?array
    {
        if (null === $inputRoles) {
            return null;
        }

        return $this->roleRepository->getByIds($inputRoles);
    }
}
