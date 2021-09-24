<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    /**
     * Method for send mail
     * @Route("/contact", name="send_mail_contact")
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactType();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $_POST['contact']['email'];
            $email = (new Email())
                ->from($name)
                ->to($this->getParameter('mailer_from'))
                ->subject('Contact formulaire')
                ->html(
                    '<h1><strong>Le contact ' . $name . ' </strong> vous à envoyé un message</h1>  
                    Au sujet de " <strong>'
                    . $_POST['contact']['sujet'] . ' : </strong> "<br><br> Son message est le suivant : <br>'
                    . $_POST['contact']['content']
                );

            $mailer->send($email);
            $this->addFlash('success', 'Votre message à bien était envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->render('component/_contactForm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
