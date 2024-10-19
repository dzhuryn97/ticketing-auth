<?php

namespace App\Tests\Integration;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Presenter\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Container;
use Ticketing\Common\Application\Command\CommandBusInterface;

abstract class AbstractIntegrationTestCase extends ApiTestCase
{
    protected Generator $faker;
    protected CommandBusInterface $commandBus;
    protected Container $container;
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();

        $this->faker = Factory::create();
        $this->commandBus = $this->container->get(CommandBusInterface::class);
        $this->em = $this->container->get(EntityManagerInterface::class);

        parent::setUp();
    }

    protected static function createClient(array $kernelOptions = [], array $defaultOptions = []): Client
    {
        if (!isset($defaultOptions['headers']['Content-type'])) {
            $defaultOptions['headers']['Content-type'] = 'application/ld+json';
        }

        return parent::createClient($kernelOptions, $defaultOptions);
    }

    protected function createClientWithCredentials(): Client
    {
        $token = $this->login();

        return self::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);
    }

    protected function login(

    ): string {

        $client = $this->createClient();
        $response = $client->request('POST', '/api/auth/login', [
            'json' => [
                'email' => UserFixtures::USER1_EMAIL,
                'password' => UserFixtures::USER1_PASSWORD,
            ],
        ]);


        $content = $response->toArray();

        return $content['token'];
    }

    protected function assertKeysExistAndNotEmpty(array $data, array $keys): void
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $data, sprintf('Key "%s" is missing from the response.', $key));
            $this->assertNotEmpty($data[$key], sprintf('Value for key "%s" is empty.', $key));
        }
    }
}
