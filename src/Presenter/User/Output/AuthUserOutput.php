<?php

namespace App\Presenter\User\Output;

use Ticketing\Common\Application\Security\AuthUserDto;

class AuthUserOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }

    public static function fromAuthUserDto(AuthUserDto $authUserDto): self
    {
        return new self(
            $authUserDto->id,
            $authUserDto->name,
        );
    }
}
