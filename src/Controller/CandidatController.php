<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\CvType;
use App\Repository\PostulationRepository;
use DateTime;
use App\Entity\Cv;
use App\Form\CvShowType;
use App\Entity\Candidat;
use App\Form\CompteCandidatType;
use App\Repository\CvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class CandidatController extends AbstractController
{
    public EntityManagerInterface $em;
    public UserPasswordEncoderInterface $passwordEncoder;
    private FlashyNotifier $flashy;
    private CvRepository $cvRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, FlashyNotifier $flashy, CvRepository $cvRepository)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashy = $flashy;
        $this->cvRepository = $cvRepository;
    }

    /**
     * @Route("/candidat/mesCvs", name="app_candidat_cv_list")
     * @param Security $security
     * @return Response
     */
    public function mesCvs(Security $security): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }

        $mesCVs_col = $security->getUser()->getMesCvs();
        $mesCVs = array();
        foreach ($mesCVs_col as $cv) {
            array_push($mesCVs, $cv);
        }
        return $this->render('candidat/mesCvs.html.twig', [
            'mesCvs' => $mesCVs
        ]);
    }


    /**
     * @Route("/candidat/createCv", name="app_candidat_cv_create")
     * @param Request $request
     * @return Response
     */
    public function createCv(Request $request): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }
        $cv = new Cv();
        $candidat = $this->getUser();

        /** @var Candidat $candidat */
        $cv->setCandidat($candidat);
        $form = $this->createForm(CvShowType::class, $cv);
        $form2 = $this->createForm(CompteCandidatType::class, $candidat);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //pour mettre les diplomes dans cv
            foreach ($cv->getFormations() as $diplome) {
                $cv->addFormation($diplome);
                $diplome->setCv($cv);
                $this->em->persist($diplome);
            }
            foreach ($cv->getExperiencesProfessionnelles() as $experience) {
                $cv->addExperiencesProfessionnelle($experience);
                $this->em->persist($experience);
            }
            //TODO:mise en place de la gestion des fichiers insérer par le user (pdf)
            //TODO:les assertions
            $cv->setUpdateAt((new DateTime('now')));
            $candidat = $cv->getCandidat();
            $this->em->persist($cv);
            $this->em->persist($candidat);

            $this->em->flush();

            $this->flashy->success('Cv Créée avec succès');

            return $this->redirectToRoute('app_candidat_cv_list');
        }
        return $this->render('candidat/createCv.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/candidat/editCv/{id}", name="app_candidat_cv_edit",methods={"GET","PUT"})
     * @param Request $request
     * @param Cv $cv
     * @return Response
     */
    public function editCv(Request $request,Cv $cv): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(CvType::class, $cv, [
            'method' => 'PUT'
        ]);
        $form2 = $this->createForm(CompteCandidatType::class, $this->getUser(), [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        //TODO: Mise en place de la gestion du controller de cv (accountController)
        if ($form->isSubmitted() && $form->isValid()) {
            //pour mettre les diplomes dans cv
            $this->em->flush();
            $this->flashy->success('Cv editéee avec succès');

            return $this->redirectToRoute('app_candidat_cv_list');
        }
        return $this->render('candidat/editCv.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'cv' => $cv
        ]);
    }

    /**
     * @Route ("/candidat/show/cv/{id<\d+>}/{annonce_id<\d+>}",name="app_candidat_cv_show")
     * @Entity("annonce", expr="repository.find(annonce_id)")
     * @param Annonce $annonce
     * @param Candidat $candidat
     * @param PostulationRepository $postulationRepository
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function showCV(Candidat $candidat,Annonce $annonce,PostulationRepository $postulationRepository,Request $request)
    {
        $cv = $postulationRepository->findOneBy(['annonce'=>$annonce,'candidat'=>$candidat])->getCvEnvoye();
        $form = $this->createForm(CvShowType::class, $cv, [
            'method' => 'PUT',
            'attr'=>[
                'disabled'=>true
                ]
        ]);
        $form2 = $this->createForm(CompteCandidatType::class, $candidat, [
            'method' => 'PUT',
            'attr'=>[
                'disabled'=>true
            ]
        ]);
        $form->handleRequest($request);
        $form2->handleRequest($request);


        return $this->render('candidat/showCv.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'cv'=>$cv,
            'candidat'=>$candidat,
            'disabled'=>'disabled'
        ]);
    }
}
