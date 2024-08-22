<?php

namespace App\Tests\Unit\Domain\User;

use App\Domain\User\User;
use App\Tests\Unit\BaseTest;

class UserTest extends BaseTest
{
    public function create_user_test()
    {

        //Arrange
        $user = new User(
            $this->faker->name,
            $this->faker->email,
            $this->faker->password,
            []
        );
        //Act

        //Assert
    }
}