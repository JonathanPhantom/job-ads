<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\User;
use App\Form\CompteEntrepriseType;
use App\Form\ModifyCompteEntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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

}
