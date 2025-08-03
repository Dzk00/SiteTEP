<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActualitesController extends AbstractController
{
    #[Route('/actualites', name: 'app_actualites')]
    public function index( 
        EntityManagerInterface $entityManager): Response
    {
        
        $blogrepo = $entityManager->getRepository(Blog::class);
        $blogs = $blogrepo->findAll();

        return $this->render('actualites/index.html.twig', [
            'blogs' => $blogs,
        ]);
    }
    #[Route('/actualites/{blogid}', name: 'app_blog')]
    public function blog( 
        EntityManagerInterface $entityManager,
        $blogid): Response
    {
        
        $blogrepo = $entityManager->getRepository(Blog::class);
        $blogs = $blogrepo->findby(['id' => $blogid]);

        return $this->render('actualites/blog.html.twig', [
            'blogs' => $blogs,
        ]);
    }
}
