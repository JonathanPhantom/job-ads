<?php

namespace App\Controller\GestionCandidature;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCandidatureController extends AbstractController
{

    //mise en place de l'injection de dependance
    /**
     * @var
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        //$this->repository = $repository;
        $this->manager = $manager;
    }

    //Postulation à une annonce

    /**
     * @param Annonce $annonce
     * @Route("/gestion/annonce/{id}/postuler", name="gestion_candidature")
     * @return Response
     */
    public function postuler(Annonce $annonce): Response
    {
        $profiles = $this->getUser()->getProfils();

        return $this->render('gestion_candidature/index.html.twig', [
            'controller_name' => 'GestionCandidatureController',
            'user' => $user,
            'annonce' => $annonce,
            'profiles' => $profiles
        ]);
    }
}
