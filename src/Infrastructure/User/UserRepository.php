<?php

namespace App\Infrastructure\User;

use App\Domain\User\Exception\UserNotFoundException;
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
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function save(User $user): void
    {
        $this->em->flush();
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    public function get(UuidInterface $id): User
    {
        $user = $this->find($id);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function findById(UuidInterface $id): ?User
    {
        return $this->find($id);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }
}
