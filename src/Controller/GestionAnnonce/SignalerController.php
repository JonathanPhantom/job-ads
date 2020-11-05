<?php

namespace App\Controller\GestionAnnonce;

use App\Entity\Annonce;
use App\Entity\Signaler;
use App\Form\SignalerType;
use App\Repository\SignalerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignalerController extends AbstractController
{

    //mise en place de l'injection de dependance
    /**
     * @var SignalerRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(SignalerRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }


    /**
     * @Route("/annonce/{id}/signaler", name="app_annonce_signaler")
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function signaleAnnonce(Request $request, Annonce $annonce): Response
    {
        if (!$this->isGranted("ROLE_CANDIDAT")){
            $this->redirectToRoute('app_login');
        }

        //TODO: faire une relation entre signaler et annonce et signaler et candidat

        $signaler = new Signaler();

        $form = $this->createForm(SignalerType::class, $signaler);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $signaler->setCandidat($this->getUser());

            //il faudrait envoyer l'id de l'annonce au controller.
            $signaler->setAnnonce($annonce);
            $this->manager->persist($signaler);
            $this->manager->flush();

            //on redirige vers la page de l'annonce ici on met home seulement pour le moment
            $id = $annonce->getId();
            return $this->redirectToRoute('app_annonce_show');
        }

        return $this->render('annonce/signaler.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
