<?php

declare(strict_types=1);

namespace App\ValueResolver\User;

use App\DTO\User\UpdateUserDTO;
use App\ValueResolver\AbstractValueResolver;

final class UpdateUserValueResolver extends AbstractValueResolver
{
    protected function getDtoClass(): string
    {
        return UpdateUserDTO::class;
    }
}
