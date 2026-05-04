<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/actualites')]
class ActualiteController extends AbstractController
{
    public function __construct(private ActualiteRepository $actualiteRepository)
    {
    }

    #[Route('/')]
    public function index(): Response
    {
        return $this->render('actualite/index.html.twig');
    }

    #[Route('/{slug}', name: 'app_actualite_details', methods: ['GET'])]
    public function details($slug)
    {
        $actualite = $this->actualiteRepository->findOneBy(['slug' => $slug]);
        $autresActions = $this->actualiteRepository->findAutresActions($slug);
        return $this->render('frontend/actualites_details.html.twig',[
            'actualite' => $actualite,
            'autres_actions' => $autresActions
        ]);
    }
}
