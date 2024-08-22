<?php

namespace App\Presenter\User\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Domain\Role\Role;
use App\Domain\User\User;
use App\Presenter\Role\RoleResource;
use App\Presenter\User\Processor\CreateUserProcessor;
use App\Presenter\User\Provider\UserProvider;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints;


#[ApiResource(
    shortName: 'User',
    operations: [
        new Get(
            openapiContext: ['summary' => 'Get user'],
            provider: UserProvider::class,
        ),
        new Post(
            openapiContext: ['summary' => 'Create User'],
            processor: CreateUserProcessor::class,
            denormalizationContext: ['groups' => 'user:create'],
            validationContext: ['groups' => 'user:create']
        )
    ]
)]
class UserResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        #[Constraints\Length(min: 1, max: 255)]
        #[Groups(groups: ['user:read'])]
        public readonly string  $id = '',

        #[Constraints\Length(min: 1, max: 255)]
        #[Constraints\NotBlank(groups: ['user:create'])]
        #[Constraints\Email(groups: ['user:create'])]
        #[Groups(groups: ['user:read','user:create'])]
        public readonly string  $email = '',

        #[Constraints\Length(min: 1, max: 255)]
        #[Constraints\NotBlank(groups: ['user:create'])]
        #[Groups(groups: ['user:read','user:create'])]
        public readonly string  $name = '',

        #[Constraints\Length(min: 1, max: 255)]
        #[Constraints\NotBlank(groups: ['user:create'])]
        #[Groups(groups: ['user:create'])]
        public readonly ?string $password = null,

        /**
         * @var array<RoleResource>
         */
        #[ApiProperty(
            writableLink: false,
        )]
        #[Groups(groups: ['user:read','user:create'])]
        public readonly array $roles = []
    )
    {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->getId(),
            email: $user->getEmail(),
            name: $user->getName(),
        );
    }
}