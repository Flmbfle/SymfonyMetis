<?php

// namespace App\Controller;

// use App\Entity\Contact;
// use App\Form\ContactFormType;
// use App\Service\MailService;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Routing\Annotation\Route;
// use symfony\bundle\FrameworkBundle\Controller\AbstractController;

// class ContactController extends AbstractController
// {
//     #[Route ('/contact', name: 'app_contact')]
    
//     public function index (Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, MailService $ms): Response
//     {
//         $form = $this -> createForm (ContactFormType::class);
        
//         $form -> handleRequest ($request);

//         if ($form -> isSubmitted () && $form -> isValid ())
//         {
//             //on crée une instance de Contact
//             $message = new Contact ();

//             // Traitement des données du formulaire
//             $message = $form -> getData ();

//             //on stocke les données récupérées dans la variable $message
//             $message -> setUtilisateur ($message -> getUtilisateur ());
//             $message -> setEmail ($message -> getEmail ());
//             $message -> setObject ($message -> getObject ());
//             $message -> setMessage ($message -> getMessage ());

//             $entityManager -> persist ($message);
//             $entityManager -> flush ();


//             // envoi de mail avec notre service MailService
//             $email = $ms -> sendMail ('qvufqf@gmail.com', $message -> getEmail (), $message -> getObject (),$message -> getMessage ());
//             ($message -> getEmail ());

//             return $this -> redirectToRoute ('app_accueil');

//         }

//         // A partir de la version 6.2 de Symfony, on n'est plus obligé d'écrire $form->createView(), il suffit de passer l'instance de FormInterface à la méthode render
//         return $this -> render ('contact/index.html.twig',
//         [
//             'form' => $form -> createView (),
//             // 'form' => $form
//         ]
//         );
//     }
// }


// Email Addresses
// =====================================================================

// use Symfony\Component\Mime\Address;

// $email = (new Email())
//     // email address as a simple string
//     ->from('fabien@example.com')

//     // email address as an object
//     ->from(new Address('fabien@example.com'))

//     // defining the email address and name as an object
//     // (email clients will display the name)
//     ->from(new Address('fabien@example.com', 'Fabien'))

//     // defining the email address and name as a string
//     // (the format must match: 'Name <email@example.com>')
//     ->from(Address::create('Fabien Potencier <fabien@example.com>'))

//     // Use addTo(), addCc(), or addBcc() methods to add more addresses:
// ;



//AJouter fichier
// ==================================================================================================================

// Use the addPart() method with a File to add files that exist on your file system:

// use Symfony\Component\Mime\Part\DataPart;
// use Symfony\Component\Mime\Part\File;
// // ...

// $email = (new Email())
//     // ...
//     ->addPart(new DataPart(new File('/path/to/documents/terms-of-use.pdf')))
//     // optionally you can tell email clients to display a custom name for the file
//     ->addPart(new DataPart(new File('/path/to/documents/privacy.pdf'), 'Privacy Policy'))
//     // optionally you can provide an explicit MIME type (otherwise it's guessed)
//     ->addPart(new DataPart(new File('/path/to/documents/contract.doc'), 'Contract', 'application/msword'))