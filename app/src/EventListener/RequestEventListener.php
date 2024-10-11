<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User\User;
use App\Service\User\TokenService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener(event: RequestEvent::class, method: 'onKernelRequest')]
readonly class RequestEventListener
{
    public function __construct(
        private Security $security,
        private TokenService $tokenService,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($user = $this->security->getUser()) {
            /** @var User $user */
            $this->tokenService->handleUserToken($user, $event->getRequest());
        }
    }
}
