<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\Adherents;
use App\Controller\Admin\BlogCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Controller\Admin\AdherentsMonacoCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BlogCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TousenPiste');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Blog', 'fas fa-list', Blog::class);
        yield MenuItem::linkToCrud('Gestion Cours', 'fas fa-list', Adherents::class)
        ->setController(AdherentsCoursCrudController::class);
        yield MenuItem::linkToCrud('Gestion Stages Monaco', 'fas fa-list', Adherents::class)
        ->setController(AdherentsMonacoCrudController::class);
        yield MenuItem::linkToCrud('Gestion Stages Toussaint', 'fas fa-list', Adherents::class)
        ->setController(AdherentsToussaintCrudController::class);
        yield MenuItem::linkToCrud('Gestion Stages Fevrier', 'fas fa-list', Adherents::class)
        ->setController(AdherentsFevrierCrudController::class);
        yield MenuItem::linkToCrud('Gestion Stages Paques', 'fas fa-list', Adherents::class)
        ->setController(AdherentsPaquesCrudController::class);
    }
}
