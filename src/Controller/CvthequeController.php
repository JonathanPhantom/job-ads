<?php

namespace App\Controller;

use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvthequeController extends AbstractController
{

    /**
     * @var CandidatRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(CandidatRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/cvtheque", name="cvtheque")
     */
    public function showUsers(): Response
    {

        $candidats = $this->repository->findAllQuery();

        return $this->render('cvtheque/index.html.twig', [
            'controller_name' => 'CvthequeController',
            'candidats' => $candidats
        ]);
    }
}
