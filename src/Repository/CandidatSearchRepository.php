<?php

namespace App\Repository;

use App\Entity\CandidatSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CandidatSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatSearch[]    findAll()
 * @method CandidatSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatSearch::class);
    }

    // /**
    //  * @return CandidatSearch[] Returns an array of CandidatSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CandidatSearch
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
