<?php

declare(strict_types=1);

namespace App\Application\User\Service;


interface TokenEncoder
{
    public function encode(array $payload): string;
}
