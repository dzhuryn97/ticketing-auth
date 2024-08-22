<?php

namespace App\Presenter\DataFixtures;

use App\Application\User\UserCase\CreateUser\CreateUserCommand;
use App\Domain\Role\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ticketing\Common\Application\Command\CommandBusInterface;
use function Symfony\Component\String\s;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    private const USERS = [
        [
            'name' => 'Admin',
            'email' => 'admin@ticketing.com',
            'password' => '123456',
            'roles' => [
                'Admin'
            ],
        ]
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::USERS as $userInput) {

            $roleIds =array_map(function ($roleName){
                return $this->getReference(sprintf('ROLE_%s',$roleName));
            },$userInput['roles']);

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
           RoleFixtures::class
       ];
    }
}
