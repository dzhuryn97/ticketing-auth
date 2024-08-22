<?php

namespace App\Presenter\DataFixtures;

use App\Application\Role\CreateRole\CreateRoleCommand;
use App\Application\Role\GetRole\GetRoleQuery;
use App\Domain\Role\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class RoleFixtures extends Fixture
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    )
    {
    }

    private const ROLES = [
        [
            'name' => 'Admin',
            'permissions' => [
                "ROLE_USER_VIEW",
                "ROLE_USER_CREATE",
                "ROLE_USER_UPDATE",
                "ROLE_USER_REMOVE",

                "ROLE_CATEGORY_VIEW",
                "ROLE_CATEGORY_CREATE",
                "ROLE_CATEGORY_UPDATE",
                "ROLE_CATEGORY_REMOVE",

                "ROLE_EVENT_VIEW",
                "ROLE_EVENT_CREATE",
                "ROLE_EVENT_UPDATE",
                "ROLE_EVENT_REMOVE",

                "ROLE_TICKET_TYPE_VIEW",
                "ROLE_TICKET_TYPE_CREATE",
                "ROLE_TICKET_TYPE_UPDATE",
                "ROLE_TICKET_TYPE_REMOVE"
            ]
        ]
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::ROLES as $roleInput) {


            $roleId = $this->commandBus->dispatch(new CreateRoleCommand(
                $roleInput['name'],
                $roleInput['permissions']
            ));

            $role = $this->queryBus->ask(new GetRoleQuery(
                $roleId
            ));

            $this->addReference(sprintf('ROLE_%s',$roleInput['name']), $role);
        }

        $manager->flush();
    }
}
