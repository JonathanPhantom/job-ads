<?php

namespace App\Controller\GestionCandidature;

use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Postulation;
use App\Entity\User;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use MercurySeries\FlashyBundle\FlashyNotifier;
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

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        //$this->repository = $repository;
        $this->manager = $manager;
    }

    //Postulation à une annonce

    /**
     * @param Request $request
     * @param Annonce $annonce
     * @param FlashyNotifier $flashy
     * @return RedirectResponse
     * @Route("/gestion/annonce/{id<\d+>}/postuler", name="app_candidat_postuler")
     */
    public function postuler(Request $request, Annonce $annonce,PostulationRepository $postulationRepository,FlashyNotifier  $flashy)
    {
        //on ajoute envoie l'utilisateur à l'annonce

        if (!$this->isGranted(User::ROLE_CANDIDAT)){
            return $this->redirectToRoute('app_login');
        }
        $candidat = $this->getUser();

        if ($postulationRepository->findBy(['candidat'=>$candidat,'annonce'=>$annonce])){
            $flashy->info('Postuler à d\'autres annonces ',$this->generateUrl("app_annonce_search"));
            return $this->redirectToRoute('app_annonce_show_id',['id'=>$annonce->getId()]);

        }
        $postulation = new Postulation();
        $postulation->setDatePostulation(new \DateTimeImmutable());
        $postulation->setAnnonce($annonce);
        $postulation->setCandidat($candidat);

        //on persist la postulation
        $this->manager->persist($postulation);
        $this->manager->flush();

        //rediriger vers la page courante.

        if ($targetPath = $this->getTargetPath($request->getSession(), 'app_candidat_provider')) {
            return new RedirectResponse($targetPath);
        }

        return $this->redirectToRoute('app_annonce_show_id',['id'=>$annonce->getId()]);
    }
}
