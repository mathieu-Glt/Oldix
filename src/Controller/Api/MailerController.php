<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/api/mail", name="api_mail")
     */
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        $datas = json_decode($request->getContent());
        $userEmail = $datas->email;
        $userSubject = $datas->subject;
        $userBody = $datas->content;
        $email = (new Email())
        ->from($userEmail)
        ->to('oldix.contact@gmail.com')
        ->subject($userSubject);
        $render = $this->renderView('mail.html.twig', ["email" => $userEmail, "subject" => $userSubject, "content" => $userBody]);
        $email->html($render);  
        $mailer->send($email);
        return $this->json("Email sent", Response::HTTP_OK);
    }
}
