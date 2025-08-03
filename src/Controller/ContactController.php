<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request, 
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact, [
            
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'error',
                'Un problème est survenu, veuillez nous contacter.'
            );
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            // Email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('tousenpisteatl@gmail.com')
                ->subject($contact->getSubject())
                ->htmlTemplate('emails/contact.html.twig');

                $mailer->send($email);

            $this->addFlash(
                'succes',
                'Votre meessage à été soumis avec succés !'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/contact/infospratiques', name: 'app_infosp')]
    public function infosp(
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact, [
            
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'error',
                'Un problème est survenu, veuillez nous contacter.'
            );
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );

            return $this->redirectToRoute('app_infosp');
        }

        return $this->render('contact/infosp.html.twig', [
            'form' => $form,
        ]);
    }
}
