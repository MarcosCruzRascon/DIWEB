<?php

namespace App\Repository;

use App\Entity\Tipoenvios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tipoenvios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tipoenvios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tipoenvios[]    findAll()
 * @method Tipoenvios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoenviosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tipoenvios::class);
    }

    // /**
    //  * @return Tipoenvios[] Returns an array of Tipoenvios objects
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
    public function findOneBySomeField($value): ?Tipoenvios
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
