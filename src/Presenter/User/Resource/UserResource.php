<?php

namespace App\Presenter\User\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\Role\Role;
use App\Domain\User\User;
use App\Presenter\Role\RoleResource;
use App\Presenter\User\Processor\CreateUserProcessor;
use App\Presenter\User\Processor\UpdateUserProcessor;
use App\Presenter\User\Provider\UserProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints;

#[ApiResource(
    shortName: 'User',
    operations: [
        new Get(
            openapiContext: ['summary' => 'Get user'],
            security: "is_granted('ROLE_USER_VIEW')"
        ),
        new GetCollection(
            security: "is_granted('ROLE_USER_VIEW')"
        ),
        new Post(
            openapiContext: ['summary' => 'Create User'],
            denormalizationContext: ['groups' => 'user:create', 'user:update'],
            validationContext: ['groups' => 'user:create', 'user:update'],
            processor: CreateUserProcessor::class
        ),
        new Put(
            openapiContext: ['summary' => 'Create User'],
            denormalizationContext: ['groups' => 'user:update'],
            validationContext: ['groups' => 'user:update'],
            processor: UpdateUserProcessor::class
        ),
    ],
    provider: UserProvider::class
)]
class UserResource
{
    #[ApiProperty(readable: true, writable: false, identifier: true)]
    #[Constraints\Length(min: 1, max: 255)]
    #[Groups(groups: ['user:read'])]
    public ?UuidInterface $id = null;

    #[Constraints\Length(min: 1, max: 255)]
    #[Constraints\NotBlank(groups: ['user:create', 'user:update'])]
    #[Constraints\Email(groups: ['user:create', 'user:update'])]
    #[Groups(groups: ['user:read', 'user:create', 'user:update'])]
    public string $email = '';

    #[Constraints\Length(min: 1, max: 255)]
    #[Constraints\NotBlank(groups: ['user:create', 'user:update'])]
    #[Groups(groups: ['user:read', 'user:create', 'user:update'])]
    public string $name = '';

    #[Constraints\Length(min: 1, max: 255)]
    #[Constraints\NotBlank(groups: ['user:create'])]
    #[Groups(groups: ['user:create', 'user:update'])]
    public ?string $password = null;

    /**
     * @var array<RoleResource>
     */
    #[ApiProperty(
        writableLink: false,
        security: 'is_granted("ROLE_USER_FILL_ROLES")'
    )]
    #[Groups(groups: ['user:read', 'user:create', 'user:update'])]
    public ?array $roles = null;

    public function __construct(
        ?UuidInterface $id = null,
        string $email = '',
        string $name = '',
        ?array $roles = null,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->roles = $roles;
    }

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->getId(),
            email: $user->getEmail(),
            name: $user->getName(),
            roles: array_map(function (Role $role) {
                return RoleResource::createFromRole($role);
            }, $user->getRoles()->toArray())
        );
    }
}
