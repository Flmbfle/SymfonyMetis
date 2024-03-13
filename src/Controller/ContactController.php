<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\DemoFormType;
use App\Form\ContactFormType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class ContactController extends AbstractController
{
    // private $csrfTokenManager;
    // public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    // {
    //     $this->csrfTokenManager = $csrfTokenManager;
    // }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, MailService $ms): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); // Récupérer les données du formulaire
            // Vérification du token CSRF
            // $submittedToken = $request->request->get('_token');
            // if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('contact_form', $submittedToken))) {
            //     throw $this->createAccessDeniedException('Invalid CSRF token.');
            //}

            //on crée une instance de Contact
            $message = new Contact ();

            // Traitement des données du formulaire
            $message = $form -> getData ();

            //on stocke les données récupérées dans la variable $message
            $message -> setEmail ($message -> getEmail ());
            $message -> setObjet ($message -> getObjet ());
            $message -> setMessage ($message -> getMessage ());

            $entityManager -> persist ($message);
            $entityManager -> flush ();


            // envoi de mail avec notre service MailService
            $ms->sendMail('erwabtot@gmail.com', $data->getEmail(), $data->getObjet(), $data->getMessage());
            ($message -> getEmail ());

            return $this -> redirectToRoute ('app_accueil');

        }

        // A partir de la version 6.2 de Symfony, on n'est plus obligé d'écrire $form->createView(), il suffit de passer l'instance de FormInterface à la méthode render
        return $this -> render ('contact/index.html.twig',
        [
            'form' => $form -> createView (),
            // 'form' => $form
        ]
        );
    }
}