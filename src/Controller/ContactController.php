<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\DemoFormType;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
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

            // Créer une instance de Contact et affecter les données
            $message = new Contact();
            $message->setEmail($data->getEmail());
            $message->setSubject($data->getSubject());
            $message->setMessage($data->getMessage());

            $entityManager->persist($message);
            $entityManager->flush();

            // Envoi de l'e-mail
            $email = (new TemplatedEmail())
                ->from($message->getEmail())
                ->to('votre@email.com')
                ->subject($message->getSubject())
                ->htmlTemplate('emails/contact_email.html.twig')
                ->context([
                    'sender_email' => $message->getEmail(),
                    'subject' => $message->getSubject(),
                    'message' => $message->getMessage(),
                ]);
        
            $mailer->send($email);
            
            return $this->redirectToRoute('app_accueil');
        }
    
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'form' => $form
        ]);
    }
}