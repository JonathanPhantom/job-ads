<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Entreprise;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\ModifyCompteEntrepriseType;
use App\Repository\CandidatRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminRecruteurController extends AbstractController
{
    const NIVEAU_FORMATION_CRITERIA = 70;
    const ANNEE_EXPERIENCE_CRITERIA = 10;
    const DOMAINE_ETUDE_CRITERIA = 20;


    /**
     * @var EntrepriseRepository
     */
    private EntrepriseRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntrepriseRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/recruteur", name="app_admin_recruteur")
     * @param Security $security
     * @return Response
     */
    public function index(Security $security): Response
    {
        $user = new Entreprise();
        $user = $security->getUser();
        if (!$this->isGranted(User::ROLE_RECRUTEUR)) {
            return $this->redirectToRoute("app_login");
        }
        return $this->render('admin_recruteur/index.html.twig', [
            'user' => $user
        ]);
    }

    //Modification du profil du recruteur

    /**
     * @param Request $request
     * @Route("/admin/recruteur/edit", name="app_admin_recruteur_edit")
     * @return Response
     */
    public function edit(Request $request)
    {
        if (!$this->isGranted(User::ROLE_RECRUTEUR)) {
            return $this->redirectToRoute("app_login");
        }

        $user = $this->getUser();
        $form = $this->createForm(ModifyCompteEntrepriseType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();

            //gestion des messages flash
            $this->addFlash('success', 'Profil modifié avec succès');

            return $this->redirectToRoute('app_admin_recruteur');
        }

        return $this->render('admin_recruteur/modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/espace-recruteur/{id}/adminAnnonce", name="app_recruteur_adminAnnonce")
     * @param Entreprise $user
     * @return Response
     */
    public function adminAnnonce(Entreprise $user)
    {
        $annonces = $this->getUser()->getAnnonces();

        return $this->render('admin_recruteur/adminAnnonce.html.twig', [
            'user' => $user,
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/espace-recruteur/candidature/{id}", name="app_recruteur_candidature")
     * @param Annonce $annonce
     * @param CandidatRepository $candidatRepository
     * @param PostulationRepository $postulationRepository
     * @return Response
     */
    public function candidatsOfOneAnnonce(Annonce $annonce, CandidatRepository $candidatRepository,PostulationRepository $postulationRepository)
    {
        $pourcentage = $this->recommandationOf($annonce);
        $candidatsRecommande = array();

        foreach ($pourcentage as $key => $value) {
            if ($value >= 10)
                array_push($candidatsRecommande, $candidatRepository->find($key));
        }
        $postulations = $annonce->getCandidatures();
        return $this->render('admin_recruteur/show_candidate.html.twig', [
            'annonce' => $annonce,
            'recommanded'=>$candidatsRecommande
        ]);
    }

    /**
     * @Route("/espace-recruteur/adminAnnonce/modify/{id}", name="app_recruteur_modifier_annonce")
     * @param Annonce $annonce
     * @param Request $request
     * @param FlashyNotifier $flashyNotifier
     * @return Response
     */
    public function modifierAnnonce(Annonce $annonce, Request $request, FlashyNotifier $flashyNotifier)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $flashyNotifier->success('Annonce modifiée avec succès');

            return $this->redirectToRoute('app_recruteur_adminAnnonce', [
                'id' => $this->getUser()->getId()
            ]);
        }

        return $this->render('annonce/editer.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);

    }

    private function recommandationOf(Annonce $annonce)
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
    }

}
