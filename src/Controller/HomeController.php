<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
  /**
   * @Route("/",name="app_home_candidat")
   */

  public function homePage() : Response
  {
      return $this->render("home/index.html.twig");
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
