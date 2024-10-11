<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Entity\User\User;
use App\Enum\GroupEnum;
use App\Enum\VoterEnum;
use App\Enum\RoleEnum;
use App\Service\User\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/api/user', name: 'api.user.')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserManager $userManager,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route(path: '/{id}', name: 'get', methods: [Request::METHOD_GET])]
    public function get(User $user): Response
    {
        $this->denyAccessUnlessGranted(VoterEnum::USER->value, $user);

        $data = $this->serializer->serialize($user, 'json', context: ['groups' => GroupEnum::USER->value]);

        return new JsonResponse($data);
    }

    #[Route(path: '/{id}', name: 'update', methods: [Request::METHOD_PUT])]
    public function update(User $user, UpdateUserDTO $dto): Response
    {
        $this->denyAccessUnlessGranted(VoterEnum::USER->value, $user);

        $this->userManager->update($user, $dto);

        return new JsonResponse();
    }

    #[Route(path: '/{id}', name: 'delete', methods: [Request::METHOD_DELETE])]
    public function delete(User $user): Response
    {
        $this->denyAccessUnlessGranted(RoleEnum::ADMIN->value);

        $this->userManager->delete($user);

        return new JsonResponse();
    }

    #[Route(name: 'create', methods: [Request::METHOD_POST])]
    public function create(CreateUserDTO $dto): Response
    {
        $this->denyAccessUnlessGranted(RoleEnum::ADMIN->value);

        $user = $this->userManager->create($dto);

        return new JsonResponse(
            $this->serializer->serialize($user, 'json', context: ['groups' => GroupEnum::USER->value])
        );
    }
}
