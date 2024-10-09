<?php

namespace App\Presenter\Role;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\Role\Role;
use App\Presenter\Role\Processor\CreateRoleProcessor;
use App\Presenter\Role\Processor\UpdateRoleProcessor;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Role',
    operations: [
        new Get(
            security: "is_granted('ROLE_ROLE_VIEW')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_ROLE_VIEW')",
        ),
        new Post(
            denormalizationContext: [
                'groups' => ['role:create'],
            ],
            security: "is_granted('ROLE_ROLE_CREATE')",
            processor: CreateRoleProcessor::class,
        ),
        new Put(
            security: "is_granted('ROLE_ROLE_UPDATE')",
            processor: UpdateRoleProcessor::class,
        ),
    ],
    normalizationContext: [
        'groups' => ['role:read'],
    ],
    paginationEnabled: false,
    provider: RoleStateProvider::class
)]
class RoleResource
{
    public function __construct(
        #[Groups(['role:read'])]
        public ?UuidInterface $id = null,
        #[Groups(['role:read', 'role:create'])]
        public string $name = '',
        #[Groups(['role:read', 'role:create'])]
        public array $permissions = [],
    ) {
    }

    public static function createFromRole(Role $role): self
    {
        return new RoleResource(
            $role->getId(),
            $role->getName(),
            $role->getPermission()
        );
    }
}
