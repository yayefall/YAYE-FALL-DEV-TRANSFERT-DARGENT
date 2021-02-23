<?php

namespace App\Repository;

use App\Entity\UserAgencePartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAgencePartenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAgencePartenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAgencePartenaire[]    findAll()
 * @method UserAgencePartenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAgencePartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAgencePartenaire::class);
    }

    // /**
    //  * @return UserAgencePartenaire[] Returns an array of UserAgencePartenaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAgencePartenaire
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
