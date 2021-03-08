<?php

namespace App\Events;

use App\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PasswordEncoderSubscriber implements EventSubscriberInterface
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * Undocumented function
     *
     * @return array[]
     * Repond a symfony en lui passsant des methodes
     */
    public static function getSubscribedEvents(): array
    {

        /* symfony: pour quoi tu m'as appelé?
         class :je veux intervenir a cet evenement (evenement VIEW)
         symfony : quand et que veux tu que je fasse?
         classe : je veux que tu m'execute cette methode (encodepassword) avant l'ecriture*/

        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE],
        ];
    }
    // fonction encode password
    public function encodePassword(ViewEvent $event)
    {
        // on capture l'element encours avant l'ecriture
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        // Execute si et seulement si notre resultat est de type User(Entity)

        if ($result instanceof User && ($method === "POST" || $method === "PUT")) {

            // on encode le password
            $hash = $this->encoder->encodePassword($result, $result->getPassword());
             // dd($hash);
            $result->setPassword($hash);

        }
    }
}
