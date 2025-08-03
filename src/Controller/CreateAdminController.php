<?php

namespace App\Controller;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateAdminController extends AbstractController
{
    // #[Route('/create/admin', name: 'app_create_admin')]
    // public function index(EntityManagerInterface $entityManager,): Response
    // {
    //  $admin = new Admin();
    //  $admin->setEmail('');

    //  $hashedPassword = password_hash('', PASSWORD_DEFAULT);
    // $admin->setPassword($hashedPassword);
     
    //  $entityManager->persist($admin);
    //  $entityManager->flush();

    //  return new Response('Nouvel administrateur créé avec succès !');
    // }
}
