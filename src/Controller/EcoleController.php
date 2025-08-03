<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleController extends AbstractController
{
    #[Route('/ecole/cours', name: 'app_ecole_cours')]
    public function index(): Response
    {
        return $this->render('ecole/cours.html.twig', [
            'controller_name' => 'EcoleController',
        ]);
    }
    #[Route('/ecole/pedagogie', name: 'app_ecole_pedagogie')]
    public function pedagogie(): Response
    {
        return $this->render('ecole/pedagogie.html.twig', [
            'controller_name' => 'EcoleController',
        ]);
    }
    #[Route('/ecole/disciplines', name: 'app_ecole_disciplines')]
    public function disciplines(): Response
    {
        return $this->render('ecole/disciplines.html.twig', [
            'controller_name' => 'EcoleController',
        ]);
    }
    #[Route('/ecole/intervenants', name: 'app_ecole_intervenants')]
    public function intervenants(): Response
    {
        return $this->render('ecole/intervenants.html.twig', [
            'controller_name' => 'EcoleController',
        ]);
    }
}
