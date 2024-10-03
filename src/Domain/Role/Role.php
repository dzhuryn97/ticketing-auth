<?php

namespace App\Domain\Role;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

#[Entity(
    repositoryClass: RoleRepositoryInterface::class
)]
class Role
{
    #[Id]
    #[Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column]
    private string $name;
    /**
     * @var array<string>
     */
    #[Column]
    private array $permission;

    /**
     * @param array<string> $permission
     */
    public function __construct(
        string $name,
        array $permission,
    ) {
        $this->id = UuidV4::uuid4();
        $this->name = $name;
        $this->permission = $permission;
    }

    /**
     * @param array<string> $permission
     */
    public function update(
        string $name,
        array $permission,
    ): void {
        $this->name = $name;
        $this->permission = $permission;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermission(): array
    {
        return $this->permission;
    }
}
