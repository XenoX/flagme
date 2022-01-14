<?php

namespace App\Repository;

use App\Entity\UserFlag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserFlag|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFlag|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFlag[]    findAll()
 * @method UserFlag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFlagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFlag::class);
    }
}
