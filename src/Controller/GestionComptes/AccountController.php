<?php

namespace App\Controller\GestionComptes;

use App\Entity\Cv;
use App\Entity\Profil;
use DateTimeImmutable;
use App\Entity\Candidat;
use App\Form\ProfilType;
use App\Entity\Entreprise;
use App\Form\CompteCandidatType;
use App\Form\CompteEntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{
    public EntityManagerInterface $em;
    public UserPasswordEncoderInterface $passwordEncoder;
    private $flashy;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder,FlashyNotifier $flashy)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashy = $flashy;
    }

    /**
     * @Route("/createAccount",name="app_candidat_compte",methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createAccount(Request $request): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CompteCandidatType::class, $candidat, [
            'attr' => [
                'class' => 'container mt-4 col-md-9 mb-5',
            ],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $candidat->setPassword(
                $this->passwordEncoder->encodePassword(
                    $candidat,
                    $form->get('plainPassword')->getData()
                )
            );
            $candidat->setIsActive(true);
            $roles = $candidat->getRoles();
            array_push($roles, "ROLE_CANDIDAT");
            $candidat->setRoles($roles);
            $candidat->setUpdateAt(new DateTimeImmutable("now"));
            $this->em->persist($candidat);
            $this->em->flush();
            
            $this->flashy->success("Vous avez désormais votre compte! Connectez-vous",$this->generateUrl("app_login"));
            return $this->redirectToRoute("app_home_candidat");
        }
        return $this->render("accounts/candidatAccount.hmtl.twig", [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/createAccount/createCv", name="app_candidat_cv")
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_CANDIDAT")
     */
    public function createCv(Request $request): Response
    {
        $Cv = new Cv();

        $form = $this->createForm(CvType::class, $Cv);
        $form->handleRequest($request);

        //TODO: Mise en place de la gestion du controller de Cv (accountController)
        if ($form->isSubmitted() && $form->isValid()) {

            //pour mettre les diplomes dans Cv
            foreach ($Cv->getDiplomes() as $diplome) {
                $diplome->setCv($Cv);
                $this->em->persist($diplome);
            }
            //TODO:mise en place de la gestion des fichiers insérer par le user (pdf)
            //TODO:les assertions

            $candidat = $this->getUser();
            $Cv->setCandidat($candidat);

            $Cv->setIsPrincipal(true);
            $this->em->persist($Cv);
            $this->em->flush();

            $this->flashy->success('success',
                'Cv Créée avec succès');

            return $this->redirectToRoute('app_home_candidat');

        }

        return $this->render('accounts/createProfil.html.twig', [
            'controller_name' => 'AccountController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/espace-recruteur/createAccount",name="app_entreprise_account")
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createEntrepriseAccount(Request $request): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(CompteEntrepriseType::class, $entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entreprise->setPassword(
                $this->passwordEncoder->encodePassword(
                    $entreprise,
                    $form->get('plainPassword')->getData()
                )
            );
            $entreprise->setIsActive(true);
            $roles = $entreprise->getRoles();
            array_push($roles, "ROLE_RECRUTEUR");
            $entreprise->setRoles($roles);
            $entreprise->setUpdateAt(new \DateTimeImmutable("now"));

            $this->em->persist($entreprise);
            $this->em->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render("accounts/entrepriseAccount.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
