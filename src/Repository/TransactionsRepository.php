<?php

namespace App\Repository;

use App\Entity\Transactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transactions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transactions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transactions[]    findAll()
 * @method Transactions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transactions::class);
    }

// lister mes transaction depot
    public function getMyTranDe(int  $id)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.userDepot', 'u')
            ->innerJoin('u.agence', 'a')
            ->innerJoin('a.compte', 'c')
            ->andWhere('c.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;
    }
// lister mes transaction retrait

    public function getMyTransRe(int  $id)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.userRetrait', 'u')
            ->innerJoin('u.agence', 'a')
            ->innerJoin('a.compte', 'c')
            ->andWhere('c.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;
    }

// lister les depots

    public function getDepot(int  $id){
        return $this->createQueryBuilder('t')
            ->innerJoin('t.compteDepot', 'c')
            ->innerJoin('c.agence', 'a')
            ->andWhere('a.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;

    }
// lister les retraits
    public function getRetrait(int  $id){
        return $this->createQueryBuilder('t')
            ->innerJoin('t.compteRetrait', 'c')
            ->innerJoin('c.agence', 'a')
            ->andWhere('a.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;
    }


// lister toutes les transactions retrait

    public function getTouTransR(int  $id){
        return $this->createQueryBuilder('t')
            ->innerJoin('t.compteRetrait', 'c')
            ->innerJoin('c.agence', 'a')
            ->andWhere('a.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;
    }


// lister toutes les transactions depot

    public function getTouTransD(int  $id){
        return $this->createQueryBuilder('t')
            ->innerJoin('t.compteDepot', 'c')
            ->innerJoin('c.agence', 'a')
            ->andWhere('a.id = :value')
            ->setParameter('value' , $id)
            ->getQuery()
            ->getResult()
            ;
    }










    // /**
    //  * @return Transactions[] Returns an array of Transactions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transactions
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
