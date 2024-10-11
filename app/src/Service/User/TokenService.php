<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\TokenRepository;
use Symfony\Component\HttpFoundation\Request;

final readonly class TokenService
{
    private const HEADER              = 'Authorization';
    private const HEADER_VALUE        = 'Bearer';
    private const HEADER_VALUE_OFFSET = 7;

    public function __construct(
        private TokenManager $tokenManager,
        private TokenRepository $tokenRepository,
    ) {
    }

    public function handleUserToken(User $user, Request $request): void
    {
        if ($token = $this->parseToken($request)) {
            if ($this->isTokenUnique($token)) {
                $this->tokenManager->create($user, $token);
            }
        }
    }

    public function isTokenUnique(string $token): bool
    {
        $existingToken = $this->tokenRepository->findOneBy(['token' => $token]);

        return $existingToken === null;
    }

    private function parseToken(Request $request): ?string
    {
        if ($authorizationHeader = $request->headers->get(self::HEADER)) {
            if (str_starts_with($authorizationHeader, sprintf('%s ', self::HEADER_VALUE))) {
                return substr($authorizationHeader, self::HEADER_VALUE_OFFSET);
            }
        }

        return null;
    }
}
