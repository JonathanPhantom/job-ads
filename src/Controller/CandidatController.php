<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cv;
use App\Form\CvType;
use App\Entity\Candidat;
use App\Form\CompteCandidatType;
use App\Repository\CvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class CandidatController extends AbstractController
{
    public EntityManagerInterface $em;
    public UserPasswordEncoderInterface $passwordEncoder;
    private $flashy;
    private $cvRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, FlashyNotifier $flashy, CvRepository $cvRepository)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashy = $flashy;
        $this->cvRepository = $cvRepository;
    }

    /**
     * @Route("/candidat/mesCvs", name="app_candidat_cv_list")
     * @param Request $request
     * @return Response
     */
    public function mesCvs(Request $request, Security $security): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }

        $mesCVs_col  = $security->getUser()->getMesCvs();
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
    public function createEditCv(Request $request): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }
        // Pour la modification
        $cv = new Cv();
        $candidat = $this->getUser();
        $cv->setCandidat($candidat);

        $form = $this->createForm(CvType::class, $cv);
        $form2 = $this->createForm(CompteCandidatType::class, $candidat);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        //TODO: Mise en place de la gestion du controller de cv (accountController)
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
     * @Route("/candidat/editCv", name="app_candidat_cv_edit",methods={"GET","PUT"})
     * @param Request $request
     * @return Response
     */
    public function editCv(Request $request): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")) {
            return $this->redirectToRoute('app_login');
        }
        $session = $request->getSession();
        // Pour la modification
        $cv = new Cv;
        $cv_array = $this->cvRepository->findBy(['id' => $request->get('idcv')]);
        if (!empty($cv_array)) {
            $cv = $cv_array[0];
            $session->set('cv',$cv);
        }else {
            $cv= $session->get('cv');
        }
        $form = $this->createForm(CvType::class, $cv,[
            'method' => 'PUT'
        ]);
        $form2 = $this->createForm(CompteCandidatType::class, $this->getUser(),[
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
            'cv'=>$cv
        ]);
    }
}
