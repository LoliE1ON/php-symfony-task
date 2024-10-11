<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\User\CreateUserDTO;
use App\Service\User\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route(path: '/api', name: 'api.')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserManager $userManager,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    #[Route(path: '/login', name: 'login', methods: [Request::METHOD_POST])]
    public function login(Request $request): Response
    {
        $url      = $this->generateUrl(route: 'api_login_check', referenceType:  UrlGeneratorInterface::ABSOLUTE_URL);
        $response = $this->httpClient->request(Request::METHOD_POST, $url, [
            'json' => json_decode($request->getContent(), true),
        ]);

        $statusCode = $response->getStatusCode();
        $content    = $response->getContent(false);

        return new JsonResponse(json_decode($content, true), $statusCode);
    }

    #[Route(path: '/register', name: 'register', methods: [Request::METHOD_POST])]
    public function register(CreateUserDTO $dto): Response
    {
        $this->userManager->create($dto);

        return new JsonResponse();
    }
}
