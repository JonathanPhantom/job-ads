<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    // /**
    //  * @return Candidat[] Returns an array of Candidat objects
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
    public function findOneBySomeField($value): ?Candidat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*
    /**
     *
     * @param Search $search
     * @return Query
     *//*
    public function findAllAdsQuery(Search $search): Query
    {
        $query = $this->findAdsQuery();


        if ($search->getCategories()->count() > 0){
            //regarder le DQL pour trouver les exemples de query
            foreach ($search->getCategories() as $k => $category){
                $query = $query
                    ->orWhere(":category$k MEMBER OF p.categories")
                    ->setParameter("category$k", $category);

            }
        }

        return $query->getQuery();
    }*/


    public function findAllQuery(): array {
        return $this->findCandidatQuery()
            ->getQuery()
            ->getResult();
    }

    public function findCandidatQuery(): QueryBuilder{
        return $this->createQueryBuilder('p');
    }

}
