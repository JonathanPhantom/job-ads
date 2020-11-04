<?php

namespace App\Controller\GestionCandidature;

use App\Entity\Annonce;
use App\Entity\Postulation;
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
     * @throws \Exception
     */
    public function postuler(Annonce $annonce): Response
    {
        //dès que le candidat clique sur postuler on envoie le candidat en cours à l'annonce
        //maintenant lors de la page d'affichage des candidats d'une annonce seulement le profil correspondant
        //au domaine d'etude de l'annonce sera affiché au cas contraire le profil par défaut.

        //on ajoute envoie l'utilisateur à l'annonce
        $postulation = new Postulation();
        $postulation->setDatePostulation(new \DateTimeImmutable());
        $postulation->setAnnonce($annonce);
        $postulation->setCandidat($this->getUser());

        //on persist la postulation
        $this->manager->persist($postulation);
        $this->manager->flush();

        //rediriger vers la page courante.

        $this->addFlash('success', 'Votre postulation à l\'annonce est éffective!!');
        $this->redirectToRoute('ho');

    }
}
