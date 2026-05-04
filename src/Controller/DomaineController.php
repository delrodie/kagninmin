<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\DomaineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/domaines')]
class DomaineController extends AbstractController
{
    public function __construct(
        private DomaineRepository $domaineRepository,
        private ActualiteRepository $actualiteRepository
    )
    {
    }

    #[Route('/', name: 'app_domaine_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('frontend/domaines.html.twig',[
            'domaines' => $this->domaineRepository->findBy(['isActif' => true])
        ]);
    }

    #[Route('/{slug}', name: 'app_domaine_details', methods: ['GET'])]
    public function details($slug)
    {
        return $this->render('frontend/domaine_details.html.twig', [
            'domaine' => $this->domaineRepository->findOneBy(['slug' => $slug]),
            'actualites' => $this->actualiteRepository->findByDomaineSlug($slug)
        ]);
    }
}
