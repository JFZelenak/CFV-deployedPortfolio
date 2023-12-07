<?php

namespace App\Repository;

use App\Entity\ArtItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtItems>
 *
 * @method ArtItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtItems[]    findAll()
 * @method ArtItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtItems::class);
    }

//    /**
//     * @return ArtItems[] Returns an array of ArtItems objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArtItems
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
