<?php

namespace App\Presenter\User\Output;

class JWT
{
    public function __construct(
        public string $token,
    ) {
    }
}
