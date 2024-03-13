<?php

namespace App\EventSubscriber;

use App\Entity\Contact;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactSubscriber implements EventSubscriber
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args) {

        $entity = $args->getObject();

        if ($entity instanceof \App\Entity\Contact){
        
            $objet = $entity->getObjet();
            $message = $entity->getMessage();

            if (preg_match("/rgpd\b/i", $objet) || preg_match("rgpd\b/i", $message) ) {
                // Envoyé un email a l'admin.
                $email = (new Email())
                    ->from('erwantotet@gmail.com')
                    ->to('admin@velvet.com')
                    ->subject('Alert RGPD')
                    ->text("Un nouveau message en rapport avec la loi sur les RGPD vous a été envoyé! L'id du message : "
                     .$entity->getId(). "\n Objet du message : " .$entity->getObjet(). "\n Texte du message : " .$entity->getMessage());

                $this->mailer->send($email);
            }
        }
    }
}