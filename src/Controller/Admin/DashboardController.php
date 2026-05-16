<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/backend', routeName: 'app_admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // return $this->redirectToRoute('admin_user_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ongkagninmin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section();
        yield MenuItem::linkTo(SlideCrudController::class, 'Sliders', 'fa-solid fa-images');
        yield MenuItem::linkTo(PartenaireCrudController::class, 'Partenaires', 'fa-solid fa-handshake');
        // <i class="fa-solid fa-person-digging"></i>

        yield MenuItem::section();
        yield MenuItem::section('Qui sommes-nous?');
        yield MenuItem::linkTo(AccueilAproposCrudController::class, 'Accueil', 'fa-solid fa-chalkboard');
        yield MenuItem::linkTo(AproposCrudController::class, 'Présentation', 'fa-solid fa-person-chalkboard');
        yield MenuItem::linkTo(MissionCrudController::class, 'Notre mission', 'fa-solid fa-rocket');
        yield MenuItem::linkTo(VisionCrudController::class, 'Notre vision', 'fa-solid fa-arrows-to-eye');
        yield MenuItem::linkTo(ValeurCrudController::class, 'Nos valeurs', 'fa-solid fa-chess-knight');

        yield MenuItem::section();
        yield MenuItem::section('Gestion');
        yield MenuItem::linkTo(DomaineCrudController::class, 'Domaine', 'fa-solid fa-globe');
        yield MenuItem::linkTo(ActualiteCrudController::class, 'Actualités', 'fa-regular fa-newspaper');
        yield MenuItem::linkTo(PhotoCrudController::class, 'Galerie', 'fa-solid fa-image');

        yield MenuItem::section();
        yield MenuItem::section('Contact');
        yield MenuItem::linkTo(CoordonneeCrudController::class, 'Coordonnées', 'fa-solid fa-envelopes-bulk');
        yield MenuItem::linkTo(CorrespondanceCrudController::class, 'Emails', 'fa-solid fa-at');
        yield MenuItem::linkTo(ObjetCrudController::class, 'Objets', 'fa-regular fa-note-sticky');
        yield MenuItem::linkTo(MessageCrudController::class, 'Messages', 'fa-regular fa-envelope');


        yield MenuItem::section();
        yield MenuItem::section('Paramètre');
        yield MenuItem::linkTo(MaintenanceCrudController::class, 'Maintenance', 'fa-solid fa-person-digging');

        if ($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::section();
            yield MenuItem::section('Sécurité');
            yield MenuItem::linkTo(UserCrudController::class, 'Utilisateurs', 'fa-solid fa-lock')
                ->setPermission('ROLE_ADMIN')
            ;
        }

    }
}
