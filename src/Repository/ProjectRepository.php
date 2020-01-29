<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'a')
            ->leftJoin('p.accounts', 'a', 'WITH', ':user MEMBER OF a.users')
            ->setParameter('user', $user)
            ->andWhere('a.id IS NOT NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllWithAccounts()
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'a')
            ->leftJoin('p.accounts', 'a')
            ->getQuery()
            ->getResult()
            ;
    }
}
