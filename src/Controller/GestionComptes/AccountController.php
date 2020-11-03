<?php

namespace App\Controller\GestionComptes;

use App\Entity\Candidat;
use App\Entity\Profil;
use App\Form\CompteCandidatType;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{
    /**
     * @Route("/createAccount",name="app_candidat_compte")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function createAccount(Request $request,UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface  $em) : Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CompteCandidatType::class,$candidat,[
            'attr'=>[
                'class'=> 'container mt-4 col-md-9 mb-5'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $candidat->setPassword(
                $passwordEncoder->encodePassword(
                    $candidat,
                    $form->get('plainPassword')->getData()
                )
            );
            $candidat->setIsActive(true);

            $candidat->setUpdateAt(new \DateTimeImmutable("now"));
            $em->persist($candidat);
            $em->flush();

            return $this->redirectToRoute("app_candidat_profil");
        }
        return $this->render("accounts/candidatAccount.hmtl.twig",[
            'form'=> $form->createView()
            ]
        );
    }

    /**
     * @Route("/createAccount/createProfil", name="app_candidat_profil")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createProfil(Request $request, EntityManagerInterface $manager): Response
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

        return $this->render('accounts/createProfil.html.twig', [
            'controller_name' => 'AccountController',
            'form' => $form->createView()
        ]);
    }
}
