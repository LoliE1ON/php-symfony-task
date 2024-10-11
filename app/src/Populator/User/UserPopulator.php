<?php

declare(strict_types=1);

namespace App\Populator\User;

use App\Entity\User\User;
use App\Model\User\UpdateUserModel;

readonly class UserPopulator
{
    public function populate(User $user, UpdateUserModel $model): User
    {
        $user->setEmail($model->getEmail());
        $user->setFirstName($model->getFirstName());
        $user->setLastName($model->getLastName());
        $user->setPatronymic($model->getPatronymic());
        $user->setBirthday($model->getBirthday());

        return $user;
    }
}
