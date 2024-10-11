<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function findByEmail(string $email, ?User $user = null): array
    {
        $queryBuilder = $this->createQueryBuilder('user')
            ->andWhere('user.email = :email')
            ->setParameter('email', $email);

        if ($user) {
            $queryBuilder
                ->andWhere('user.id != :id')
                ->setParameter('id', $user->getId());
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
