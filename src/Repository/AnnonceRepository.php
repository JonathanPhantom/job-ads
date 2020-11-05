<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //Trouver toutes les annonces

    /**
     * @return Annonce[]
     */
    public function findAllQuery(): array {
        return $this->findAdsQuery()
            ->getQuery()
            ->getResult();
    }

    //creation d'une requete
    public function findAdsQuery(): QueryBuilder{
        return $this->createQueryBuilder('p');
    }

//    //Pagination des annonces
//    public function getAnnonces($page, $nbpages){
//        $query = $this->createQueryBuilder('a');
//         $query->leftJoin('a.categories', 'c')->addSelect('c')->orderBy('a.datePublication', 'ASC')->getQuery();
//
//         $query->setFirstResult(($page-1) * $nbpages)->setMaxResults($nbpages);
//
//         return new Paginator($query, true);
//    }

    public function getAllAnnonces(){
        $query = $this->createQueryBuilder('a');
        $query->leftJoin('a.categories', 'c')->addSelect('c')->orderBy('a.datePublication', 'ASC')->getQuery();

        //$query->setFirstResult(($page-1) * $nbpages)->setMaxResults($nbpages);

        return $query;
    }

    public function getAllAnnoncesSearch(Search $search){
        $query = $this->createQueryBuilder('a');

        if ($search->getDomaineEtude()){
            /*foreach ($search->getDomaineEtude() as $k => $domaineEtude ){
                $domaineEtudes = $domaineEtude->getValue();*/
                $query = $query
                    ->andWhere("a.domaineEtude = '".$search->getDomaineEtude()->getValue()."'")
                    ;
           /* }*/
        }

        if ($search->getLocalites()){
           /* foreach ( as $k => $localite){
                $localites = $localite->getValue();*/
                $query = $query
                    ->leftJoin("a.proprietaire", 'b')
                    ->andWhere("b.localite = '".$search->getLocalites()->getValue()."'");
           /* }*/
        }

        if ($search->getTypeContrat()){
            /*foreach ($search->getTypeContrat() as $k => $typeContrat){
                $typeContrats = $typeContrat->getValue();*/
                $query = $query
                    ->andWhere("a.typeContrat = '".$search->getTypeContrat()->getValue()."'")
                    ;
            /*}*/
        }
        if ($search->getNiveauEtude()){
            /*foreach ($search->getNiveauEtude() as $k => $niveauFormation){
                $niveauFormations = $niveauFormation->getValue();*/
                $query = $query
                    ->andWhere("a.niveauFormation = '".$search->getNiveauEtude()->getValue()."'")
                    ;
           /* }*/
        }

        return $query->getQuery();
    }


}
