<?php

namespace App\Presenter\User\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Presenter\User\Output\AuthUserOutput;
use App\Presenter\User\Output\JWT;
use App\Presenter\User\Payload\Login;
use App\Presenter\User\Processor\LoginProcessor;
use App\Presenter\User\Provider\AuthenticationProvider;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: 'login',
            input: Login::class,
            output: JWT::class,
            processor: LoginProcessor::class
        ),
        new Get(
            uriTemplate: 'current',
            output: AuthUserOutput::class,
            provider: AuthenticationProvider::class,
            security: "is_granted('ROLE_USER')"
        )
    ],
    shortName: 'auth',
)]
class Authentication
{
}