<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/partenaires')]
class PartenaireController extends AbstractController
{
    public function __construct(private PartenaireRepository $partenaireRepository)
    {
    }

    #[Route('/', name: 'app_partenaire_list')]
    public function list(): Response
    {
        return $this->render('frontend/partenaires_list.html.twig',[
            'partenaires' => $this->partenaireRepository->findBy(['isActif' => true]),
        ]);
    }

    public function widget(): Response
    {
        $partenaires = $this->partenaireRepository->findBy(
            ['isActif' => true],
        );

        return $this->render('frontend/partenaires_list.html.twig', [
            'partenaires' => $partenaires
        ]);
    }
}
