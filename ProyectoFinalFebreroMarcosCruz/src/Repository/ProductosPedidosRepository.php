<?php

namespace App\Repository;

use App\Entity\ProductosPedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductosPedidos|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductosPedidos|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductosPedidos[]    findAll()
 * @method ProductosPedidos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosPedidosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductosPedidos::class);
    }

    // /**
    //  * @return ProductosPedidos[] Returns an array of ProductosPedidos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductosPedidos
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
