<?php

namespace App\Repository;

use App\Entity\DetailTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailTransaction[]    findAll()
 * @method DetailTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailTransaction::class);
    }

    // /**
    //  * @return DetailTransaction[] Returns an array of DetailTransaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailTransaction
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
