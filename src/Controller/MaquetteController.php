<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maquette')]
class MaquetteController extends AbstractController
{
    #[Route('/', name: 'app_maquette')]
    public function index(): Response
    {
        return $this->render('maquette/index.html.twig', [
            'controller_name' => 'MaquetteController',
        ]);
    }
	
	#[Route('/page', name:'app_maquette_page')]
	public function page()
	{
		return $this->render('maquette/page.html.twig');
	}
}
