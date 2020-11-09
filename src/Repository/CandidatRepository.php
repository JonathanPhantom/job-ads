<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\CandidatSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @param AnnonceSearch $search
     * @return Query
     *//*
    public function findAllAdsQuery(AnnonceSearch $search): Query
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

    //recherchons les candidats avec des attributs précis

    public function findAllCandidat(CandidatSearch $search){
        $query = $this->createQueryBuilder('c');
//        $valeur =

        if ($search->getDomaineEtude()){
            foreach ($search->getDomaineEtude() as $k => $domaineEtude){
                $domaineEtu = $domaineEtude->getValue();
                $query = $query
                    ->leftJoin('c.mesCvs', 'j')
                    ->andWhere("j.SecteurEtudeSouhaite = '[".$domaineEtu."]'")
                ;
            }
        }



        if ($search->getNiveauFormation()){
            foreach ($search->getNiveauFormation() as $k => $niveauFormation){
                $niveauForm = $niveauFormation->getValue();
                $query = $query
                    ->leftJoin('c.mesCvs', 'b')
                    ->andWhere("b.niveauFormation = '$niveauForm'");

            }
        }

        if ($search->getNom()){
            $name = $search->getNom();
            $query = $query
                ->andWhere('c.nom LIKE :searchterm')
                ->setParameter('searchterm', '%'.$name.'%');
        }

        if ($search->getLocalite()){
            $local = $search->getLocalite()->getValue();
            $query = $query
                ->andWhere("c.localite = '$local'");
        }

        return $query->getQuery();

    }


//    public function getAllAnnoncesSearch(AnnonceSearch $search){
//        $query = $this->createQueryBuilder('a');
//
//        if ($search->getDomaineEtude()){
//            foreach ($search->getDomaineEtude() as $k => $domaineEtude ){
//                $domaineEtudes = $domaineEtude->getValue();
//                $query = $query
//                    ->orWhere("a.domaineEtude = '$domaineEtudes'")
//                ;
//            }
//        }
//
//        if ($search->getLocalites()){
//            foreach ($search->getLocalites() as $k => $localite){
//                $localites = $localite->getValue();
//                $query = $query
//                    ->leftJoin("a.proprietaire", 'b')
//                    ->orWhere("b.localite = '$localites'");
//            }
//        }
//
//        if ($search->getTypeContrat()){
//            foreach ($search->getTypeContrat() as $k => $typeContrat){
//                $typeContrats = $typeContrat->getValue();
//                $query = $query
//                    ->orWhere("a.typeContrat = '$typeContrats'")
//                ;
//            }
//        }
//        if ($search->getNiveauEtude()){
//            foreach ($search->getNiveauEtude() as $k => $niveauFormation){
//                $niveauFormations = $niveauFormation->getValue();
//                $query = $query
//                    ->orWhere("a.niveauFormation = '$niveauFormations'")
//                ;
//            }
//        }
//
//        return $query->getQuery();
//    }

     /*public function getRightCandidats(){
        $query = $this->createQueryBuilder('c');

        $query->leftJoin('c.candidatures', 'p')->addSelect('p')->
     }*/
}
