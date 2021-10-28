<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();
        $datas = $event->getData();
        if(!$user instanceof User){
            return false;
        }

        $email = $user->getEmail();
        $datas['email'] = $email;
        if(!$user->getPseudo()){
            $datas['pseudo'] = $user->getPseudo();
        }
        $event->setData($datas);

    }
}
