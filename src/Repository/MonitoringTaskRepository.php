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

    public function findTasksForCheck()
    {
        return $this->createQueryBuilder('t')
            ->where('t.nextCheckAt < :currentAt OR t.nextCheckAt IS NULL')
            ->setParameter('currentAt', new \DateTime())
            ->getQuery()
            ->getResult()
        ;
    }
}
