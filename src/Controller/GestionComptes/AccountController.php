<?php

namespace App\Controller\GestionComptes;

use DateTime;
use App\Entity\Cv;
use App\Form\CvShowType;
use DateTimeImmutable;
use App\Entity\Candidat;
use App\Entity\Entreprise;
use App\Entity\ExperienceProfessionnelle;
use App\Form\CompteCandidatType;
use App\Form\CompteEntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    private FlashyNotifier $flashy;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, FlashyNotifier $flashy)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashy = $flashy;
    }

    /**
     * @Route("/createAccount",name="app_candidat_compte",methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
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

            $this->flashy->success("Vous avez désormais votre compte! Connectez-vous", $this->generateUrl("app_login"));
            return $this->redirectToRoute('app_login');
        }
        return $this->render("accounts/candidatAccount.hmtl.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/espace-recruteur/createAccount",name="app_entreprise_account")
     *
     * @param Request $request
     * @return Response
     * @throws Exception
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
            $this->flashy->success("Vous avez désormais votre compte! Connectez-vous", $this->generateUrl("app_login"));

            return $this->redirectToRoute('app_login');
        }
        return $this->render("accounts/entrepriseAccount.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
