<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from('hello@example.com')

            ->to(new Address('ryan@example.com'))
            
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)

            ->subject('Thanks for singing up !')

            ->htmlTemplate('emails/signup.html.twig')
            
            ->context([
                'expiration_date' => new DateTime('+7 days'),
                'username' => 'foo',
            ])
                
            // Intergrer image
            ->addPart((new DataPart(fopen('/path/to/images/logo.png', 'r'), 'logo', 'image/png'))->asInLine())

            ->addPart((new DataPart(new File('/path/to/images/signature.gif'), 'footer-signature', 'image/gif'))->asInLine())

            // Integrer des fichiers joints
            
            ->addPart(new DataPart(new File('/path/to/documents/terms-of-use.pdf')))

            ->addPart(new DataPart(new File('/path/to/documents/privacy.pdf'), 'Privacy Policy'))

            ->addPart(new DataPart(new File('/path/to/documents/contract.doc'), 'Contract'), 'application/msword');

        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}


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