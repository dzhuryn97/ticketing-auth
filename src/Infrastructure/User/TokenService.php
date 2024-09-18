<?php

namespace App\Infrastructure\User;

use App\Application\User\TokenEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class TokenService implements TokenEncoder
{
    public function __construct(
        private readonly JWTEncoderInterface $JWTEncoder,
    ) {
    }

    public function encode(array $payload): string
    {
        return $this->JWTEncoder->encode($payload);
    }
}
