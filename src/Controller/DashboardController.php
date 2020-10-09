<?php

namespace App\Controller;

// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Controller\Admin\ConferenceCrudController;
use App\Entity\Conference;
use App\Entity\Comment;

class DashboardController extends AbstractDashboardController
{
    // /**
    //  * @Route("/admin", name="dashboard")
    //  * @return Response
    //  */
    // public function index(): Response
    // {
    //     return parent::index();
    // }

    /**
     * @Route("/admin")
     * @return Response
     */
    public function index(): Response
    {
        // Redirigir a algún controlador CRUD
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(ConferenceCrudController::class)->generateUrl());

        // También puede redirigir a diferentes páginas dependiendo del usuario actual
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // También puede renderizar alguna plantilla para mostrar un tablero adecuado
        // (consejo: es más fácil si su plantilla se extiende desde @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('KEYWAPP!')
            // you can include HTML contents too (e.g. to link to an image)
            // ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')

            // the path defined in this method is passed to the Twig asset() function
            ->setFaviconPath('favicon.ico')

            // the domain used by default is 'messages'
            ->setTranslationDomain('my-custom-domain')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Conference'),
            MenuItem::linkToCrud('Conference', 'fa fa-tags', Conference::class),

            MenuItem::section('Comment'),
            MenuItem::linkToCrud('Comment', 'fa fa-comment', Comment::class)
                ->setQueryParameter('sortField', 'createdAt')
                ->setQueryParameter('sortDirection', 'DESC'),
        ];
    }
}
