<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\ContactEntretien;
use App\Form\ContactEntretienType;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactEntretienController extends AbstractController
{
    /**
     * @Route("/espace-recruteur/adminCandidat/contact/{id}/{ad}", name="app_recruteur_contact_entretien")
     * @param Candidat $candidat
     * @param Request $request
     * @param Annonce $annonce
     * @param FlashyNotifier $flashyNotifier
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function contactCandidat(Candidat $candidat, Request $request, Annonce $annonce, FlashyNotifier $flashyNotifier, \Swift_Mailer $mailer): Response
    {
        $contactEntretien = new ContactEntretien();
        $form = $this->createForm(ContactEntretienType::class, $contactEntretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $message = (new \Swift_Message('Entretien d\'embauche pour l\'annonce '.$this->getUser()->getNomEntreprise()))
                ->setFrom(''.$this->getUser()->getEmail())
                ->setTo(''.$candidat->getEmail())
                ->setBody('Bonjour suite à votre postulation à l\'annonce '.$annonce->getTitreAnnonce().' Nous vous invitons à un entretien d\'embauche le 
                '.$contactEntretien->getDateEntretien()->format('d/m/y').' à '.$contactEntretien->getHeureEntretien(),
                    'text/html'
                );

            $mailer->send($message);

            $flashyNotifier->success('Email envoyé à l\'utilisateur');

            $this->redirectToRoute('app_recruteur_home', [
                'id' => $this->getUser()->getId()
            ]);
        }


        return $this->render('contact_entretien/index.html.twig', [
            'controller_name' => 'ContactEntretienController',
            'form' => $form->createView()
        ]);
    }
}
