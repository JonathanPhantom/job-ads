<?php

namespace App\Controller\GestionComptes;

use App\Entity\Candidat;
use App\Entity\Entreprise;
use App\Entity\Profil;
use App\Form\CompteCandidatType;
use App\Form\CompteEntrepriseType;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{
    public EntityManagerInterface $em;
    public UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EntityManagerInterface  $em,UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/createAccount",name="app_candidat_compte")
     * @param Request $request
     * @return Response
     */
    public function createAccount(Request $request) : Response
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
                $this->passwordEncoder->encodePassword(
                    $candidat,
                    $form->get('plainPassword')->getData()
                )
            );
            $candidat->setIsActive(true);

            $candidat->setUpdateAt(new \DateTimeImmutable("now"));
            $this->em->persist($candidat);
            $this->em->flush();

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
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function createProfil(Request $request): Response
    {
        $profil = new Profil();
        
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        //TODO: Mise en place de la gestion du controller de profil (accountController)
        if ($form->isSubmitted() && $form->isValid()){

            //pour mettre les diplomes dans profil
            foreach ($profil->getDiplomes() as $diplome){
                $diplome->setProfil($profil);
                $this->em->persist($diplome);
            }

            //TODO:mise en place de la gestion des fichiers insérer par le user (pdf)
            //TODO:les assertions

            $candidat = $this->getUser();
            $profil->setCandidat($candidat);
            $this->em->persist($profil);
            $this->em->flush();

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

    /**
     * @Route("/espace-recruteur/createAccount",name="app_entreprise_account")
     * 
     */
    public function createEntrepriseAccount(Request $request) : Response
    {
        $entreprise = new Entreprise();
        $form   =   $this->createForm(CompteEntrepriseType::class,$entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entreprise->setPassword(
                $this->passwordEncoder->encodePassword(
                    $entreprise,
                    $form->get('plainPassword')->getData()
                )
            );
            $entreprise->setIsActive(true);
            $this->em->persist($entreprise);
            $this->em->flush();

            return $this->redirectToRoute('app_espace_recruteur');
        }
        return $this->render("accounts/entrepriseAccount.html.twig",[
            'form'=>$form->createView(),
        ]);
    }
}
