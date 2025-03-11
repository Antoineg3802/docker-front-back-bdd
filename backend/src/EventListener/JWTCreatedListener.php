<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();
        $payload = $event->getData();

        // Ajout de l'email dans le payload
        $payload['email'] = $user->getUserIdentifier();

        // Vous pouvez ajouter d'autres informations si nécessaire
        $event->setData($payload);
    }
}
