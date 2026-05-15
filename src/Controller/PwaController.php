<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/offline')]
class PwaController extends AbstractController
{
    #[Route('/', name: 'app_pwa_offline', methods: ['GET'])]
    public function offline(): Response
    {
        return $this->render('frontend/pwa_offline.html.twig',[
            'app_name' => "ONG KAGNINMIN"
        ]);
    }
}
