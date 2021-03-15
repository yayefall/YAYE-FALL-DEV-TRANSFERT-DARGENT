<?php

namespace App\Repository;

use App\Entity\BlocTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlocTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlocTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlocTransaction[]    findAll()
 * @method BlocTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlocTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlocTransaction::class);
    }

    // /**
    //  * @return BlocTransaction[] Returns an array of BlocTransaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlocTransaction
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
