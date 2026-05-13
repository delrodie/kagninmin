<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\DomaineRepository;
use App\Repository\MaintenanceRepository;
use App\Repository\SlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function __construct(
        private MaintenanceRepository $maintenanceRepository,
        private SlideRepository $slideRepository,
        private ActualiteRepository $actualiteRepository,
        private DomaineRepository $domaineRepository,
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        if ($this->maintenanceRepository->findOneBy(['isActif' => true],['id' => "DESC"])){
            return $this->redirectToRoute('app_maintenance');
        }
        return $this->render('frontend/home.html.twig',[
            'slides' => $this->slideRepository->findBy(['isValid' => true],['id' => "DESC"]),
            'actualites' => $this->actualiteRepository->findBy(['isAtif' => true], ['dateAction' => 'DESC']),
            'domaines' => $this->domaineRepository->findBy(['isActif' => true])
        ]);
    }

    #[Route('/maintenance', name: 'app_maintenance')]
    public function maintenance(): Response
    {
        if ($this->maintenanceRepository->findBy(['isActif' => false],['id' => "DESC"])){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('frontend/maintenance.html.twig');
    }
}
