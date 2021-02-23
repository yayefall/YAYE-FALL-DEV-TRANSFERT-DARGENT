<?php

namespace App\Repository;

use App\Entity\GestionAgencePartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GestionAgencePartenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method GestionAgencePartenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method GestionAgencePartenaire[]    findAll()
 * @method GestionAgencePartenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GestionAgencePartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GestionAgencePartenaire::class);
    }

    // /**
    //  * @return GestionAgencePartenaire[] Returns an array of GestionAgencePartenaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GestionAgencePartenaire
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
