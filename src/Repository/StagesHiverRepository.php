<?php

namespace App\Repository;

use App\Entity\StagesHiver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StagesHiver>
 *
 * @method StagesHiver|null find($id, $lockMode = null, $lockVersion = null)
 * @method StagesHiver|null findOneBy(array $criteria, array $orderBy = null)
 * @method StagesHiver[]    findAll()
 * @method StagesHiver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagesHiverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StagesHiver::class);
    }

//    /**
//     * @return StagesHiver[] Returns an array of StagesHiver objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StagesHiver
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
