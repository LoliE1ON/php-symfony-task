<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Model\User\UpdateUserModel;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDTO implements UpdateUserModel
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    private string $email;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $firstName = null;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $lastName = null;

    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    private ?string $patronymic = null;

    #[Assert\Date]
    private ?DateTimeInterface $birthday = null;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTimeInterface $birthday): void
    {
        $this->birthday = $birthday;
    }
}
