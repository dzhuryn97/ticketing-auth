<?php

namespace App\Presenter\DataFixtures;

use App\Application\User\CreateUser\CreateUserCommand;
use App\Application\User\GetUsers\GetUsersQuery;
use App\Domain\Role\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public const string USER1_EMAIL = 'admin@ticketing.com';
    public const string USER1_PASSWORD = '123456';

    private const USERS = [
        [
            'name' => 'Admin',
            'email' => self::USER1_EMAIL,
            'password' => self::USER1_PASSWORD,
            'roles' => [
                'Admin',
            ],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $users = $this->queryBus->ask(new GetUsersQuery());
        if ($users) {
            return;
        }

        foreach (self::USERS as $userInput) {
            $roleIds = array_map(function ($roleName) {
                /** @var Role $role */
                $role = $this->getReference(sprintf('ROLE_%s', $roleName));

                return $role->getId();
            }, $userInput['roles']);

            $this->commandBus->dispatch(new CreateUserCommand(
                $userInput['name'],
                $userInput['email'],
                $userInput['password'],
                $roleIds
            ));
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}
