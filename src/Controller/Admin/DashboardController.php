<?php

namespace App\Controller\Admin;

use App\Repository\PageViewRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[AdminDashboard(routePath: '/backend', routeName: 'app_admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private PageViewRepository $pageViewRepo,
        private ChartBuilderInterface $chartBuilder,
        private RequestStack $requestStack
    ) {}

    public function index(): Response
    {
        $startDate = $this->requestStack->getCurrentRequest()->query->get('start')
            ? new \DateTimeImmutable($this->requestStack->getCurrentRequest()->query->get('start'))
            : new \DateTimeImmutable('-30 days');

        $endDate = $this->requestStack->getCurrentRequest()->query->get('end')
            ? new \DateTimeImmutable($this->requestStack->getCurrentRequest()->query->get('end'))
            : new \DateTimeImmutable('today');

        $totalVisits      = $this->pageViewRepo->countTotalVisits();
        $todayVisits      = $this->pageViewRepo->countVisitsToday();
        $weekVisits       = $this->pageViewRepo->countVisitsThisWeek();
        $periodVisits     = $this->pageViewRepo->countVisitsBetween($startDate, $endDate);

        $todayUnique      = $this->pageViewRepo->countUniqueVisitorsToday();
        $periodUnique     = $this->pageViewRepo->countUniqueVisitorsBetween($startDate, $endDate);

        $topPages         = $this->pageViewRepo->getTopPages(10);
        $sources          = $this->pageViewRepo->getTrafficSources();
        $countries        = $this->pageViewRepo->getCountriesStats();

        $chartData = $this->pageViewRepo->getStatsByDate($startDate, $endDate); //dd($chartData);

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_column($chartData, 'date'),
            'datasets' => [[
                'label' => 'Visites',
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'data' => array_column($chartData, 'visits'),
                'tension' => 0.4,
                'fill' => true,
            ]]
        ]); //dd($chart);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'scales' => ['y' => ['beginAtZero' => true]],
        ]);

        return $this->render('admin/dashboard.html.twig', [
            'totalVisits'   => $totalVisits,
            'todayVisits'   => $todayVisits,
            'weekVisits'    => $weekVisits,
            'periodVisits'  => $periodVisits,
            'todayUnique'   => $todayUnique,
            'periodUnique'  => $periodUnique,
            'topPages'      => $topPages,
            'sources'       => $sources,
            'countries'     => $countries,
            'visitsChart'   => $chart,
            'startDate'     => $startDate->format('Y-m-d'),
            'endDate'       => $endDate->format('Y-m-d'),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ongkagninmin')
            ->renderContentMaximized()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section();
        yield MenuItem::linkTo(SlideCrudController::class, 'Sliders', 'fa-solid fa-images');
        yield MenuItem::linkTo(PartenaireCrudController::class, 'Partenaires', 'fa-solid fa-handshake');
        // <i class="fa-solid fa-person-digging"></i> <i class="fa-solid fa-person-through-window"></i>

        yield MenuItem::section();
        yield MenuItem::section('Qui sommes-nous?');
        yield MenuItem::linkTo(AccueilAproposCrudController::class, 'Accueil', 'fa-solid fa-chalkboard');
        yield MenuItem::linkTo(AproposCrudController::class, 'Présentation', 'fa-solid fa-person-chalkboard');
        yield MenuItem::linkTo(MissionCrudController::class, 'Notre mission', 'fa-solid fa-rocket');
        yield MenuItem::linkTo(VisionCrudController::class, 'Notre vision', 'fa-solid fa-arrows-to-eye');
        yield MenuItem::linkTo(ValeurCrudController::class, 'Nos valeurs', 'fa-solid fa-chess-knight');
        yield MenuItem::linkTo(FooterAproposCrudController::class, 'Footer', 'fa-solid fa-person-through-window');

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
