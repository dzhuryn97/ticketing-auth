<?php

namespace App\Application\User\CreateUser;

use App\Domain\Role\RoleRepositoryInterface;
use App\Domain\User\Exception\EmailIsUsedException;
use App\Domain\User\PasswordHasherInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly RoleRepositoryInterface $roleRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command)
    {
        $this->ensureEmailIsUnique($command->email);

        $roles = $command->roles ? $this->roleRepository->getByIds($command->roles) : [];

        $user = new User(
            $command->name,
            $command->email,
            $this->passwordHasher->hash($command->password),
            $roles
        );

        $this->userRepository->add($user);

        return $user;
    }

    private function ensureEmailIsUnique(string $email): void
    {
        if ($this->userRepository->findUserByEmail($email)) {
            throw new EmailIsUsedException($email);
        }
    }
}
