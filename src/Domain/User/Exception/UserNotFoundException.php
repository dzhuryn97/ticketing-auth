<?php

namespace App\Domain\User\Exception;

use App\Domain\User\User;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class UserNotFoundException extends EntityNotFoundException
{
    public function __construct($id)
    {
        parent::__construct($id, User::class);
    }
}
