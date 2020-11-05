<?php

namespace App\Controller;

use App\Controller\GestionAnnonce\AnnonceController;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    /**
     * @Route("/",name="app_home_candidat")
     * @param Request $request
     * @param AnnonceRepository $annonceRepository
     * @param EntrepriseRepository $entrepriseRepository
     * @return Response
     */

    public function homePage(Request $request,AnnonceRepository $annonceRepository, EntrepriseRepository $entrepriseRepository,EntityManagerInterface  $em) : Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute("app_annonce_show");
        }
        $annonces = $annonceRepository->getAllAnnoncesSearch($search)->getResult();
        $entreprises = $entrepriseRepository->findWithMaxResult();

      return $this->render("home/index.html.twig",[
          'form'=>$form->createView(),
          'entreprises'=>$entreprises
      ]);
  }

    /**
     * homeEspaceRecruteur
     *@Route("/espace-recruteur",name="app_espace_recruteur")
     * @return Response
     */
    public function homeEspaceRecruteur() : Response
    {
        return $this->render("home/recruteur.html.twig");
    }
}
