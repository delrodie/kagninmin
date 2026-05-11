<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/galerie')]
class GalerieController extends AbstractController
{
    public function __construct(private ActualiteRepository $actualiteRepository)
    {
    }

    #[Route('/', name: 'app_galerie_index')]
    public function index(): Response
    {
        return $this->render('frontend/galerie.html.twig',[
            'actualites' => $this->actualiteRepository->findBy(['isAtif' => true], ['dateAction' => 'DESC']),
        ]);
    }

    #[Route('/{slug}', name: 'app_galerie_details', methods: ['GET'])]
    public function details($slug)
    {
        return $this->render('frontend/galerie_details.html.twig',[
            'actualite' => $this->actualiteRepository->findOneBy(['slug' => $slug]),
        ]);
    }
}
