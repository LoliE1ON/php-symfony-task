<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Model\User\CreateUserModel;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserDTO extends UpdateUserDTO implements CreateUserModel
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 8, max: 255)]
    private string $password;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
