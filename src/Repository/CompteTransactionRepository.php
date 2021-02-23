<?php

namespace App\Repository;

use App\Entity\CompteTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteTransaction[]    findAll()
 * @method CompteTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteTransaction::class);
    }

    // /**
    //  * @return CompteTransaction[] Returns an array of CompteTransaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompteTransaction
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
