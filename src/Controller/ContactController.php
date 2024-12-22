<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType;
use App\DTO\ContactDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class ContactController extends AbstractController
{
    #[Route('/Contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {

        $data = new ContactDTO();
        $form = $this->createform(ContactType::class, $data);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $mail = (new TemplatedEmail())
                    ->from($data->email)
                    ->to('sandra.rocher@hotmail.fr')
                    ->subject($data->subject)  
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context([
                        'data' => $data]);

                    try {
                        $mailer->send($mail);
                        $this->addFlash('success', 'Votre message a bien été envoyé');
                        return $this->redirectToRoute('app_contact');

                    } catch(\Exception $e) {
                        $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez reessayer.' . $e);
                    }
                }
                    return $this->render('contact/contact.html.twig', [
                        'form' => $form,
                    ]);
    }
}
