<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\CompteEntrepriseType;
use App\Form\ModifyCompteEntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/admin/recruteur/{id<\d+>}", name="admin_recruteur")
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
     * @Route("/admin/recruteur/edit", name="app_admin_modify")
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

}
