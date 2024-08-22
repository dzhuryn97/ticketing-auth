<?php

namespace App\Domain\Role;


use App\Presenter\Role\Processor\UpdateRoleProcessor;
use Ramsey\Uuid\UuidInterface;

interface RoleRepositoryInterface
{
    /**
     * @return array<Role>
     */
    public function all():array;

    public function findById(UuidInterface $id):?Role;

    /**
     * @param array<UuidInterface> $ids
     * @return array<Role>
     */
    public function getByIds(array $ids);
    public function add(Role $role):void;
}