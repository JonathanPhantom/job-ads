<?php

namespace App\Repository;

use App\Entity\NiveauDePoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiveauDePoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauDePoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauDePoste[]    findAll()
 * @method NiveauDePoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauDePosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauDePoste::class);
    }

    // /**
    //  * @return NiveauDePoste[] Returns an array of NiveauDePoste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NiveauDePoste
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
