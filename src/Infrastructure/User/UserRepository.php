<?php

namespace App\Infrastructure\User;

use App\Domain\User\Exception\UserEntityNotFoundException;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email
        ]);
    }

    public function get(UuidInterface $id): User
    {
        $user = $this->find($id);
        if(!$user){
            throw new UserEntityNotFoundException();
        }

        return $user;
    }

    public function findById(UuidInterface $id): ?User
    {
        return $this->find($id);
    }
}
