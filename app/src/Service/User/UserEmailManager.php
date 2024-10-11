<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\User;
use App\Exception\User\EmailAlreadyRegisteredException;
use App\Repository\User\UserRepository;

final readonly class UserEmailManager
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function ensureUniqueEmail(string $email, ?User $user = null): void
    {
        if ($this->userRepository->findByEmail($email, $user)) {
            throw new EmailAlreadyRegisteredException();
        }
    }
}
