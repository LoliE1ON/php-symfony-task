<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\User\User;
use App\Enum\RoleEnum;
use App\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, User>
 */
class UserVoter extends Voter
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === VoterEnum::USER->value and $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$token->getUser()) {
            return false;
        }

        return $token->getUser() === $subject or $this->authorizationChecker->isGranted(RoleEnum::ADMIN->value);
    }
}
