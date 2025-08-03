<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    #[Route('/cours/minis', name: 'app_cours_minis')]
    public function minis(): Response
    {
        return $this->render('cours/minis.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/cours/junior', name: 'app_cours_junior')]
    public function junior(): Response
    {
        return $this->render('cours/junior.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/cours/kids', name: 'app_cours_kids')]
    public function kids(): Response
    {
        return $this->render('cours/kids.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/cours/ados', name: 'app_cours_ados')]
    public function ados(): Response
    {
        return $this->render('cours/ados.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/cours/adultes', name: 'app_cours_adultes')]
    public function adultes(): Response
    {
        return $this->render('cours/adultes.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}
