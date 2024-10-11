<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\APIValidationException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: ExceptionEvent::class, method: 'onKernelException')]
class APIValidationExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof APIValidationException) {
            /** @var int $code */
            $code = $exception->getStatusCode();

            $response = new JsonResponse(status: $code);
            $responseData = [];

            foreach ($exception->getList() as $item) {
                $responseData[] = [
                    'error' => $item->getMessage(),
                    'atPath' => $item->getPropertyPath(),
                ];
            }

            $response->setData($responseData);
            $event->setResponse($response);
        }
    }
}
