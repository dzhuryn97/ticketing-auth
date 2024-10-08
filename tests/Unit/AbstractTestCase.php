<?php

namespace App\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Ticketing\Common\Domain\DomainEntity;

abstract class AbstractTestCase extends TestCase
{
    protected \Faker\Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    protected function assertDomainEventRaised(DomainEntity $entity, $respectiveEventClass)
    {
        $domainEvents = $entity->getDomainEvents();

        $filtered = array_filter($domainEvents, function (object $event) use ($respectiveEventClass) {
            return $event instanceof $respectiveEventClass;
        });


        $this->assertCount(1, $filtered, sprintf('Domain event %s not found', $respectiveEventClass));
    }
}
