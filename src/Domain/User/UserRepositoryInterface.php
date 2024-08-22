<?php

namespace App\Domain\User;

use App\Domain\User\Exception\UserEntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function findUserByEmail(string $email): ?User;

    /**
     * @throws UserEntityNotFoundException
     */
    public function get(UuidInterface $id):User;
    public function findById(UuidInterface $id):?User;
}