<?php

namespace App\Repository;

use App\Entity\Visitas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visitas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visitas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visitas[]    findAll()
 * @method Visitas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visitas::class);
    }

    // /**
    //  * @return Visitas[] Returns an array of Visitas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visitas
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
