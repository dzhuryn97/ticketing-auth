<?php

declare(strict_types=1);

namespace App\Application\User;


interface TokenEncoder
{
    public function encode(array $payload): string;
}
