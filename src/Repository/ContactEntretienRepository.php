<?php

namespace App\Repository;

use App\Entity\ContactEntretien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactEntretien|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactEntretien|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactEntretien[]    findAll()
 * @method ContactEntretien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactEntretienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactEntretien::class);
    }

    // /**
    //  * @return ContactEntretien[] Returns an array of ContactEntretien objects
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
    public function findOneBySomeField($value): ?ContactEntretien
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
