<?php

namespace App\Application\User\UpdateUser;

use App\Domain\Role\RoleRepositoryInterface;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function __invoke(UpdateUserCommand $command)
    {
        $user = $this->userRepository->findById($command->userId);
        if (!$user) {
            throw new UserNotFoundException();
        }

        $roles = null !== $command->roles ? $this->roleRepository->getByIds($command->roles) : null;

        $user->update(
            $command->name,
            $command->email,
            $command->password,
            $roles,
        );

        $this->flusher->flush();
    }
}
