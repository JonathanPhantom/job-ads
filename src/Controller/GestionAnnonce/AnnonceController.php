<?php

namespace App\Controller\GestionAnnonce;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Search;
use App\Form\AnnonceType;
use App\Form\SearchType;
use App\Repository\AdsRepository;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\MesEnumType;

class AnnonceController extends AbstractController
{



    //mise en place de l'injection de dependance
    /**
     * @var AnnonceRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(AnnonceRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }



    /**
     * @Route("/annonce", name="create_annonce")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createAnnonce(Request $request): Response
    {

        //declaration d'une nouvelle annonce
        $annonce = new Annonce();
        //formulaire
        $form = $this->createForm(AnnonceType::class, $annonce);

        //gestion des requetes
        $form->handleRequest($request);


        //traitement du formulaire
        if($form->isSubmitted() && $form->isValid()){
            $annonce->setProprietaire($this->getUser());
            //Mise à jour de la date de publication
            $annonce->setDatePublication(new \DateTime());

            $this->manager->persist($annonce);


            $this->manager->flush();
            $id = $annonce->getId();
            $this->addFlash('success', 'Annonce créée avec succès');
            //on redirige vers la page d'affichage des annonces ou la page d'admin des annonces
            return $this->redirectToRoute('show_one_ad', [
                'id' => $id
            ]);
        }

        return $this->render('annonce/index1.html.twig', [
            'controller_name' => 'AnnonceController',
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }


    //test affiche une annonce

    /**
     * @Route("/annonce/{id}", name="show_one_ad")
     * @param Annonce $annonce
     * @return Response
     */
    public function showOneAd(Annonce $annonce){
        return $this->render("annonce/oneannonce.html.twig", [
            'current_menu' => 'annonce',
            'annonce' => $annonce
        ]);
    }

    // modification d'une annonce

    /**
     * @param Annonce $annonce
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/annonce/{id}/modifier", name="modifer_une_annonce")
     * @throws \Exception
     */
    public function edit(Annonce $annonce, Request $request)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->manager->flush();


            $this->addFlash('success', 'Annonce modifer avec succès');
            $id = $this->getUser()->getId();
            //au lieu de home retourner la route d'admin des annonces de chaque user
            return $this->redirectToRoute('show_one_ad', [
                'id' => $id
            ]);
        }

        return $this->render('annonce/editerune.html.twig', [
            'ads' => $annonce,
            'form' => $form->createView()
        ]);
    }

    //suppression d'une annonce

    /**
     * @param Annonce $annonce
     * @param Request $request
     * @return RedirectResponse
     * @Route("/annonce/supprimer/{id}", name="delete_ad", methods={"DELETE"})
     */
    public function delete(Annonce $annonce, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->get('_token'))){
            $this->manager->remove($annonce);
            $this->manager->flush();

            $this->addFlash('success', 'Annonce supprimé avec succès');
        }

        $id = $this->getUser()->getId();
        //on redirige vers la page d'édition de l'admin des biens
        //Mais là on redirige vers la page d'acceuil
        return $this->redirectToRoute('app_home_recruteur', [
            //'id' => $id
        ]);
    }


    //lister tous les annonces
    //implémenter le paginator pour les annonces
    //et aussi implémenter les la recherche avec Search
    //Page d'acceuil

    /**
     * @Route("/showAllAds", name="index_ads")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showAds(Request $request){

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()){
//
//            $annonces = $this->repository->findAllAdsQuery($search);
//            dump($annonces);
//        }


        //$ads = $paginator->paginate($this->repository->findAllAdsQuery($search), $request->query->getInt('page', 1), 3);
        /*$annonce = new Annonce();
         if($page < 1){
             throw $this->createNotFoundException("Page ".$page." innexistante");

         }
         $parpages = 3;
          $listesAnnonces = $this->getDoctrine()->getManager()->getRepository(Annonce::class)->getAnnonces($page, $parpages);
          $nbpages = ceil(count($listesAnnonces) / $parpages);

          /* if ($page>$nbpages){
               throw $this->createNotFoundException("Page ".$page. " inexistante");
           }**///


        $annonces = $this->repository->getAllAnnoncesSearch($search)->getResult();

        dump($annonces);

        return $this->render('home/annonces.html.twig', [
            'form' => $form->createView(),
            'ads' => $annonces
            //'listesAnnonces'=> $annonces,//$listesAnnonces,
             /*'nbpages'=>$nbpages,
            'page'=>$page,
            'annonce' => $annonce*/
           // 'form' => $form->createView()
        ]);
    }
}
