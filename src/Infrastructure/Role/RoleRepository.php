<?php

namespace App\Infrastructure\Role;

use App\Domain\Role\Role;
use App\Domain\Role\RoleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository implements RoleRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
        $this->em = $this->getEntityManager();
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function findById(UuidInterface $id): ?Role
    {
        return $this->find($id);
    }

    public function add(Role $role): void
    {
        $this->em->persist($role);
        $this->em->flush();
    }

    public function getByIds(array $ids)
    {
        return $this->findBy([
            'id' => $ids,
        ]);
    }

    public function save(Role $role): void
    {
        $this->em->flush();
    }
}
