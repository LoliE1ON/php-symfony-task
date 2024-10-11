<?php

declare(strict_types=1);

namespace App\Factory\User;

use App\Entity\User\User;
use App\Model\User\CreateUserModel;
use App\Populator\User\UserPopulator;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

readonly class UserFactory
{
    public function __construct(
        private UserPopulator $userPopulator,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function create(CreateUserModel $model): User
    {
        $user = new User();

        $this->userPopulator->populate($user, $model);

        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher($user);
        $user->setPassword($passwordHasher->hash($model->getPassword()));

        return $user;
    }
}
