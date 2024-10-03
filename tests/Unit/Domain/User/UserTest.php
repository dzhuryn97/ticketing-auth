<?php

namespace App\Tests\Unit\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserCreatedDomainEvent;
use App\Domain\User\UserUpdatedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;

// When_StateUnderTest_Expect_ExpectedBehavior
class UserTest extends AbstractTestCase
{
    /** @test */
    public function createShouldRaiseDomainEventWhenUserCreated(): void
    {
        // Act
        $user = new User(
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->password(),
            []
        );

        $this->assertDomainEventRaised($user, UserCreatedDomainEvent::class);
    }

    /** @test */
    public function updateShouldRaiseDomainEventWhenUserUpdated()
    {
        // Arrange
        $user = new User(
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->password(),
            []
        );
        $user->clearDomainEvents();

        // Act
        $user->update(
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->password(),
            []
        );

        // Assert
        $this->assertDomainEventRaised($user, UserUpdatedDomainEvent::class);
    }

    /** @test */
    public function updateShouldNotRaiseDomainEventUserNotUpdated()
    {
        // Arrange
        $user = new User(
            $name = $this->faker->name(),
            $email = $this->faker->email(),
            $this->faker->password(),
            $roles = []
        );
        $user->clearDomainEvents();

        // Act
        $user->update(
            $name,
            $email,
            null,
            $roles
        );

        // Assert
        $this->assertCount(0, $user->releaseDomainEvents());
    }
}
