<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\Entity\User\Token;
use App\Entity\User\User;

class TokenFactory
{
    public function create(User $user, string $token): Token
    {
        $entity = new Token();

        $entity->setToken($token);
        $entity->setUser($user);

        return $entity;
    }
}
