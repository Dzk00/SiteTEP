<?php

namespace App\Repository;

use App\Entity\StagesToussaint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StagesToussaint>
 *
 * @method StagesToussaint|null find($id, $lockMode = null, $lockVersion = null)
 * @method StagesToussaint|null findOneBy(array $criteria, array $orderBy = null)
 * @method StagesToussaint[]    findAll()
 * @method StagesToussaint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagesToussaintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StagesToussaint::class);
    }

//    /**
//     * @return StagesToussaint[] Returns an array of StagesToussaint objects
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

//    public function findOneBySomeField($value): ?StagesToussaint
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
