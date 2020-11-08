<?php

namespace App\Controller\GestionCandidature;

use App\Entity\Annonce;
use App\Entity\Postulation;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class GestionCandidatureController extends AbstractController
{

    use TargetPathTrait;
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
     * @param Request $request
     * @param Annonce $annonce
     * @return RedirectResponse
     * @throws \Exception
     * @Route("/gestion/annonce/{id}/postuler", name="app_candidat_postuler")
     */
    public function postuler(Request $request, Annonce $annonce)
    {
        //dès que le candidat clique sur postuler on envoie le candidat en cours à l'annonce
        //maintenant lors de la page d'affichage des candidats d'une annonce seulement le profil correspondant
        //au domaine d'etude de l'annonce sera affiché au cas contraire le profil par défaut.

        //on ajoute envoie l'utilisateur à l'annonce

        if (!$this->isGranted("ROLE_CANDIDAT")){
            return $this->redirectToRoute('app_login');
        }
        $postulation = new Postulation();
        $postulation->setDatePostulation(new \DateTimeImmutable());
        $postulation->setAnnonce($annonce);
        $postulation->setCandidat($this->getUser());

        //on persist la postulation
        $this->manager->persist($postulation);
        $this->manager->flush();

        //rediriger vers la page courante.

        $this->addFlash('success', 'Votre postulation à l\'annonce est éffective!!');
        if ($targetPath = $this->getTargetPath($request->getSession(), 'app_candidat_provider')) {
            return new RedirectResponse($targetPath);
        }

        return $this->redirectToRoute('app_annonce_show');
    }
}
