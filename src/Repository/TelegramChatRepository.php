<?php

namespace App\Repository;

use App\Entity\TelegramChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TelegramChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelegramChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TelegramChat[]    findAll()
 * @method TelegramChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelegramChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TelegramChat::class);
    }
}
