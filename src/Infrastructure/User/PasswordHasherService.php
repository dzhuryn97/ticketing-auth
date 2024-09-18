<?php

namespace App\Infrastructure\User;

use App\Domain\User\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\PasswordHasherInterface as SymfonyPasswordHasher;

class PasswordHasherService implements PasswordHasherInterface
{
    public function __construct(
        private readonly SymfonyPasswordHasher $passwordHasher = new NativePasswordHasher(),
    ) {
    }

    public function hash(string $plainPassword): string
    {
        return $this->passwordHasher->hash($plainPassword);
    }

    public function verify(string $plainPassword, string $hashedPassword): bool
    {
        return $this->passwordHasher->verify($hashedPassword, $plainPassword);
    }
}
