<?php

namespace App\Repository;

use App\Entity\MonitoringTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonitoringTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonitoringTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonitoringTask[]    findAll()
 * @method MonitoringTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonitoringTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonitoringTask::class);
    }

    // /**
    //  * @return MonitoringTask[] Returns an array of MonitoringTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MonitoringTask
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
