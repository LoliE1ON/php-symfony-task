<?php

declare(strict_types=1);

namespace App\Model\User;

use DateTimeInterface;

interface UpdateUserModel
{
    public function getEmail(): string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getPatronymic(): ?string;

    public function getBirthday(): ?DateTimeInterface;
}
