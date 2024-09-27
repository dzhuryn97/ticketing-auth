<?php

namespace App\Domain\User;

use App\Domain\User\Exception\UserNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function save(User $user): void;

    public function findUserByEmail(string $email): ?User;

    /**
     * @throws UserNotFoundException
     */
    public function get(UuidInterface $id): User;

    public function findById(UuidInterface $id): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;
}
