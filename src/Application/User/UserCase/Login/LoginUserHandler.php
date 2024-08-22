<?php

namespace App\Application\User\UserCase\Login;

use App\Domain\Auth\Exception\InvalidCredentialsException;
use App\Domain\User\PasswordHasherInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

class LoginUserHandler
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordHasherInterface $passwordHasher,
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function handle(LoginUserCommand $command): User
    {
        $user = $this->userRepository->findUserByEmail($command->email);

        if(!$user){
            throw new InvalidCredentialsException();
        }

        if(!$this->passwordHasher->verify($command->password, $user->getPassword())){
            throw new InvalidCredentialsException();
        }

        return $user;
    }
}