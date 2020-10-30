<?php

namespace App\Controller\GestionCandidature;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCandidatureController extends AbstractController
{

    //Postulation à une annonce
    /**
     * @Route("/gestion/candidature", name="gestion_candidature")
     */
    public function index(): Response
    {
        return $this->render('gestion_candidature/index.html.twig', [
            'controller_name' => 'GestionCandidatureController',
        ]);
    }
}
