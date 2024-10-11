<?php

declare(strict_types=1);

namespace App\Model\User;

interface CreateUserModel extends UpdateUserModel
{
    public function getPassword(): string;
}
