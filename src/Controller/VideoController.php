<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GalerieVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/galerie-video')]
class VideoController extends AbstractController
{
    public function __construct(private GalerieVideoRepository $videoRepository)
    {
    }

    #[Route('/')]
    public function index(): Response
    {
        return $this->render('frontend/video.html.twig',[
            'videos' => $this->videoRepository->findAllVideo()
        ]);
    }

    #[Route('/{slug}', name: 'app_video_show', methods: ['GET'])]
    public function show($slug)
    {
        return $this->render('frontend/video_details.html.twig',[
            'video' => $this->videoRepository->findOneBy(['slug' => $slug]),
            'videos' => $this->videoRepository->findOtherVideo($slug)
        ]);
    }
}
