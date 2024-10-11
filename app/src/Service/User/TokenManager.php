<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\Token;
use App\Entity\User\User;
use App\Factory\User\TokenFactory;
use Doctrine\ORM\EntityManagerInterface;

final readonly class TokenManager
{
    public function __construct(
        private TokenFactory $tokenFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(User $user, string $token): Token
    {
        $token = $this->tokenFactory->create($user, $token);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }
}
