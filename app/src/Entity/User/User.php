<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Enum\GroupEnum;
use App\Enum\RoleEnum;
use App\Repository\User\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([GroupEnum::USER->value])]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Groups([GroupEnum::USER->value])]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([GroupEnum::USER->value])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([GroupEnum::USER->value])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([GroupEnum::USER->value])]
    private ?string $patronymic = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([GroupEnum::USER->value])]
    private ?DateTimeInterface $birthday = null;

    /** @var string[] */
    #[ORM\Column(type: Types::JSON)]
    #[Groups([GroupEnum::USER->value])]
    private array $roles = [RoleEnum::USER->value];

    /** @var ArrayCollection<int, Token> */
    #[ORM\OneToMany(targetEntity: Token::class, mappedBy: 'user')]
    private Collection $tokens;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();

        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     * @return void
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    /**
     * @return ArrayCollection<int, Token>
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    /**
     * @param ArrayCollection<int, Token> $tokens
     * @return void
     */
    public function setTokens(Collection $tokens): void
    {
        $this->tokens = $tokens;
    }

    public function addToken(Token $token): void
    {
        if (!$this->getTokens()->contains($token)) {
            $this->getTokens()->add($token);
            $token->setUser($this);
        }
    }
}
