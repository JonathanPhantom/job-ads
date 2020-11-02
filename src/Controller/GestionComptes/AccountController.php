<?php

namespace App\Controller\GestionComptes;

use App\Entity\Diplome;
use App\Entity\Profil;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/recruteur/createProfil", name="recruteur_profil")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createProfi(Request $request, EntityManagerInterface $manager): Response
    {
        $profil = new Profil();



        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);

        //TODO: Mise en place de la gestion du controller de profil (accountController)
        if ($form->isSubmitted() && $form->isValid()){

            //pour mettre les diplomes dans profil
            foreach ($profil->getDiplomes() as $diplome){
                $diplome->setProfil($profil);
                $manager->persist($diplome);
            }

            //TODO:mise en place de la gestion des fichiers insérer par le user (pdf)
            //TODO:les assertions
            $candidat = $this->getUser();
            $profil->setCandidat($candidat);
            $manager->persist($profil);
            $manager->flush();

            $this->addFlash('success',
                'Profil Créée avec succès');

            //on renvoie la page du user mais ici pour le test j'ai mis le home.
            return $this->redirectToRoute('home');

        }

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'form' => $form->createView()
        ]);
    }
}
