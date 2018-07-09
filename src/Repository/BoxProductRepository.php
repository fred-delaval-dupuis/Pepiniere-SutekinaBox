<?php

namespace App\Repository;

use App\Entity\BoxProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoxProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoxProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoxProduct[]    findAll()
 * @method BoxProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoxProduct::class);
    }

//    /**
//     * @return BoxProduct[] Returns an array of BoxProduct objects
//     */
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
    public function findOneBySomeField($value): ?BoxProduct
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
