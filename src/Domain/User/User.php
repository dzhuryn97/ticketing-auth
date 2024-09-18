<?php

namespace App\Domain\User;

use App\Domain\Role\Role;
use App\Infrastructure\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;
use Ticketing\Common\Domain\Support\CollectionHelpers;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User extends DomainEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column]
    private string $email;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $password;

    /**
     * @var Collection<Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class)]
    private Collection $roles;

    public function __construct(
        string $name,
        string $email,
        string $password,
        array $roles,
    ) {
        $this->id = UuidV4::uuid4();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roles = new ArrayCollection($roles);

        $this->raiseDomainEvent(new UserCreatedDomainEvent($this->id));
    }

    public function update(
        string $name,
        string $email,
        ?string $password,
        ?array $roles = null,
    ): void {
        if (
            $name === $this->name
            && $email === $this->email
            && (null === $roles || $this->isRoleEquals($roles))
            && null === $password
        ) {
            return;
        }


        $this->name = $name;
        $this->email = $email;

        if ($roles && !$this->isRoleEquals($roles)) {
            $this->roles->clear();
            foreach ($roles as $role) {
                $this->addRole($role);
            }
        }

        if ($password) {
            $this->password = $password;
        }

        $this->raiseDomainEvent(new UserUpdatedDomainEvent($this->id));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPermissions(): array
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            $permissions = array_merge($role->getPermission(), $permissions);
        }

        return $permissions;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    private function addRole(Role $role): void
    {
        if (!$this->hasRole($role)) {
            $this->roles->add($role);
        }
    }

    private function removeRole(Role $role): void
    {
        if ($this->hasRole($role)) {
            $this->roles->removeElement($role);
        }
    }

    private function hasRole(Role $role): bool
    {
        return $this->roles->contains($role);
    }

    private function isRoleEquals(array $inputRoles): bool
    {
        return CollectionHelpers::isCollectionsEqual(new ArrayCollection($inputRoles), $this->roles, function (Role $role1, Role $role2) {
            return $role1->getId()->equals($role2->getId());
        });
    }
}
