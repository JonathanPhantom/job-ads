<?php

namespace App\Controller\GestionCandidature;

use App\Entity\Annonce;
use App\Entity\Cv;
use App\Entity\Postulation;
use App\Entity\User;
use App\Repository\CandidatRepository;
use App\Repository\PostulationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class GestionCandidatureController extends AbstractController
{
    /*const NIVEAU_FORMATION_CRITERIA = 70;
    const ANNEE_EXPERIENCE_CRITERIA = 10;
    const DOMAINE_ETUDE_CRITERIA = 20;*/

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
     * @param Cv|null $cv
     * @param PostulationRepository $postulationRepository
     * @param FlashyNotifier $flashy
     * @return RedirectResponse
     * @Route("/gestion/annonce/{id<\d+>}/cv/{id2<\d+>}/postuler", name="app_candidat_postuler", defaults={"id2"=0})
     */
    public function postuler(Request $request, Annonce $annonce,?Cv $cv,PostulationRepository $postulationRepository, FlashyNotifier $flashy)
    {
        //on ajoute envoie l'utilisateur à l'annonce

        if (!$this->isGranted(User::ROLE_CANDIDAT)) {
            return $this->redirectToRoute('app_login');
        }
        $candidat = $this->getUser();

        if ($postulationRepository->findBy(['candidat' => $candidat, 'annonce' => $annonce])) {
            $flashy->info('Postuler à d\'autres annonces ', $this->generateUrl("app_annonce_search"));
            return $this->redirectToRoute('app_annonce_show_id', ['id' => $annonce->getId()]);

        }
        if ($cv != null){

        $postulation = new Postulation();
        $postulation->setDatePostulation(new DateTimeImmutable());
        $postulation->setAnnonce($annonce);
        $postulation->setCandidat($candidat);
        $postulation->setCvEnvoye($cv);

        //on persist la postulation
        $this->manager->persist($postulation);
        $this->manager->flush();
        }

        //rediriger vers la page courante.

        if ($targetPath = $this->getTargetPath($request->getSession(), 'app_candidat_provider')) {
            return new RedirectResponse($targetPath);
        }

        return $this->redirectToRoute('app_annonce_show_id', ['id' => $annonce->getId()]);
    }


    // Annonce : toutes les candidatures, verification
    /*private function recommander(Annonce $annonce)
    {

        $candidatures = $annonce->getCandidatures();
        $candidats = array();

        foreach ($candidatures as $candidature) {
            array_push($candidats, $candidature->getCandidat());
        }
        //
        $pourcentage = array();

        $matching = 0;
        foreach ($candidats as $candidat) {
            $icv = 0;

            foreach ($candidat->getMesCvs() as $cv) {
                $i_form = 0;
                if ($cv->getAnneeExperience() === $annonce->getAnneeExperience()) {
                    $matching += $this::ANNEE_EXPERIENCE_CRITERIA;
                }

                if (in_array($cv->getSecteurEtudeSouhaite(), $annonce->getDomaineEtudes())) {
                    $matching += $this::DOMAINE_ETUDE_CRITERIA;
                }
                foreach ($cv->getFormations() as $formation) {
                    if ($formation->getNiveau() === $annonce->getNiveauFormation()) {
                        $matching += $this::NIVEAU_FORMATION_CRITERIA;
                    }
                    $i_form++;
                }
                if ($i_form !== 0)
                    $matching /= $i_form;
                $icv++;
            }
            if ($icv !== 0)
                $matching /= $icv;
            $pourcentage[$candidat->getId()] = $matching;
        }

        return $pourcentage;
    }*/
}
