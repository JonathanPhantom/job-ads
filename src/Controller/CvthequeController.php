<?php

namespace App\Controller;

use App\Entity\CandidatSearch;
use App\Form\CandidatSearchType;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvthequeController extends AbstractController
{

    /**
     * @var CandidatRepository
     */
    private CandidatRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(CandidatRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/cvtheque", name="app_cvtheque")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function showUsers(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new CandidatSearch();


        $form = $this->createForm(CandidatSearchType::class, $search,[
            'attr'=>[
                'class'=>'auto_submit_form'
            ]
        ]);
//        $query = $this->manager->createQuery('SELECT u FROM MyProject\Model\User u WHERE u.age > 20');
//        $valeur = $query->getResult();
//
//        dd($valeur);

        $form->handleRequest($request);
        //$ads = $paginator->paginate($this->repository->findAllAdsQuery($search), $request->query->getInt('page', 1), 3);

        $candidats = $paginator->paginate($this->repository->findAllCandidat($search)->getResult(), $request->query->getInt('page', 1), 6);
        //$candidats = $this->repository->findAllCandidat($search)->getResult();


        return $this->render('cvtheque/index.html.twig', [
            'candidats' => $candidats,
            'form' => $form->createView()
        ]);
    }
}
