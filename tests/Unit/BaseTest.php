<?php

namespace App\Tests\Unit;

use Faker\Factory;

class BaseTest
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
}