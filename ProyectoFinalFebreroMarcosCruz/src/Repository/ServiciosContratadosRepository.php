<?php

namespace App\Repository;

use App\Entity\ServiciosContratados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiciosContratados|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiciosContratados|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiciosContratados[]    findAll()
 * @method ServiciosContratados[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiciosContratadosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiciosContratados::class);
    }

    // /**
    //  * @return ServiciosContratados[] Returns an array of ServiciosContratados objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiciosContratados
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
