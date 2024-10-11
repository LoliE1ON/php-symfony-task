<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\User;
use App\Exception\User\SelfDeletionException;
use App\Factory\User\UserFactory;
use App\Model\User\CreateUserModel;
use App\Model\User\UpdateUserModel;
use App\Populator\User\UserPopulator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class UserManager
{
    public function __construct(
        private Security $security,
        private UserFactory $userFactory,
        private EntityManagerInterface $entityManager,
        private UserPopulator $userPopulator,
        private UserEmailManager $userEmailManager,
    ) {
    }

    public function create(CreateUserModel $model): User
    {
        $this->userEmailManager->ensureUniqueEmail($model->getEmail());

        $user = $this->userFactory->create($model);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update(User $user, UpdateUserModel $model): User
    {
        $this->userEmailManager->ensureUniqueEmail($model->getEmail(), $user);

        $user = $this->userPopulator->populate($user, $model);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function delete(User $user): void
    {
        if ($this->security->getUser() === $user) {
            throw new SelfDeletionException();
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
