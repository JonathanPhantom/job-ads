<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    /**
     * @Route("/",name="app_home_candidat")
     * @param $request
     * @return Response
     */

  public function homePage(Request $request) : Response
  {
      $search = new Search();
      $form = $this->createForm(SearchType::class,$search);
      $form->handleRequest($request);
      return $this->render("home/index.html.twig",[
          'form'=>$form->createView()
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
