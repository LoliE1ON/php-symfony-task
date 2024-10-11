<?php

declare(strict_types=1);

namespace App\ValueResolver\User;

use App\ValueResolver\AbstractValueResolver;
use App\DTO\User\CreateUserDTO;

final class CreateUserValueResolver extends AbstractValueResolver
{
    protected function getDtoClass(): string
    {
        return CreateUserDTO::class;
    }
}
