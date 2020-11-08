<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Entreprise;
use App\Form\AnnonceType;
use App\Form\CompteEntrepriseType;
use App\Form\ModifyCompteEntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecruteurController extends AbstractController
{

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
     * @Route("/espace-recruteur/{id<\d+>}", name="app_recruteur_home")
     * @param Entreprise $entreprise
     * @return Response
     */
    public function index(Entreprise $entreprise): Response
    {
        return $this->render('admin_recruteur/index.html.twig', [
            'user' => $entreprise
        ]);
    }

    //Modification du profil du recruteur

    /**
     * @param Request $request
     * @Route("/espace-recruteur/edit", name="app_recruteur_modify")
     * @return Response
     */
    public function edit(Request $request)
    {
            $user = $this->getUser();
            $form = $this->createForm(ModifyCompteEntrepriseType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $this->manager->persist($user);
                $this->manager->flush();

                //gestion des messages flash
                $this->addFlash('success', 'Profil modifié avec succès');

                $this->redirectToRoute('admin_recruteur', [
                    'id' => $this->getUser()->getId()
                ]);
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
    public function adminAnnonce(Entreprise $user){
        $annonces = $this->getUser()->getAnnonces();

        return $this->render('admin_recruteur/adminAnnonce.html.twig', [
            'user' => $user,
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/espace-recruteur/candidature/{id}", name="app_recruteur_candidature")
     * @param Annonce $annonce
     * @return Response
     */
    public function candidatOfOneAnnonce(Annonce $annonce){
        return $this->render('admin_recruteur/show_candidate.html.twig', [
            'annonce' => $annonce
        ]);
    }

    /**
     * @Route("/espace-recruteur/adminAnnonce/modify/{id}", name="app_recruteur_modifier_annonce")
     * @param Annonce $annonce
     * @param Request $request
     * @return Response
     */
    public function modifierAnnonce(Annonce $annonce, Request $request, FlashyNotifier $flashyNotifier)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
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


}
