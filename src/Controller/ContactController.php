<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CoordonneeRepository;
use App\Repository\ObjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    public function __construct(
        private CoordonneeRepository $coordonneeRepository,
        private ObjetRepository $objetRepository
    )
    {
    }

    #[Route('/', name:'app_contact_index')]
    public function index(): Response
    {
        return $this->render('frontend/contact.html.twig',[
            'coordonnee' => $this->coordonneeRepository->findOneBy([],['id' => 'DESC']),
            'objets' => $this->objetRepository->findBy(['isActif' => true])
        ]);
    }

    #[Route('/footer', name: 'app_contact_footer')]
    public function footer()
    {
        return $this->render('frontend/_contact_footer.html.twig',[
            'coordonnee' => $this->coordonneeRepository->findOneBy([],['id' => "DESC"])
        ]);
    }
}
