<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AccueilApropos;
use App\Repository\AccueilAproposRepository;
use App\Repository\AproposRepository;
use App\Repository\FooterAproposRepository;
use App\Repository\MissionRepository;
use App\Repository\ValeurRepository;
use App\Repository\VisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/qui-sommes-nous')]
class PresentationController extends AbstractController
{
    public function __construct(
        private AproposRepository        $aproposRepository,
        private MissionRepository        $missionRepository,
        private VisionRepository         $visionRepository,
        private ValeurRepository         $valeurRepository,
        private AccueilAproposRepository $accueilAproposRepository, private readonly FooterAproposRepository $footerAproposRepository,
    )
    {
    }

    #[Route('/', name: 'app_presentation_index')]
    public function index(): Response
    {
        return $this->render('frontend/presentation.html.twig');
    }

    #[Route('/{slug}', name: 'app_presentation_widget', methods: ['GET'])]
    public function widget($slug): Response
    {
        return match ($slug){
            'apropos' => $this->apropos(),
            'mission' => $this->mission(),
            'vision' => $this->vision(),
            'valeur' => $this->valeur(),
            'illustration' => $this->illustration(),
            'footer' => $this->footer(),
            default => $this->accueil_presentation($slug),
        };
    }

    public function apropos(): Response
    {
        return $this->render('frontend/apropos.html.twig',[
            'apropos' => $this->aproposRepository->findOneBy(['isActif' => true], ['id' => "DESC"])
        ]);
    }

    public function mission(): Response
    {
        return $this->render('frontend/mission.html.twig',[
            'mission' => $this->missionRepository->findOneBy(['isActif' => true], ['id' => "DESC"])
        ]);
    }

    public function vision(): Response
    {
        return $this->render('frontend/vision.html.twig',[
            'vision' => $this->visionRepository->findOneBy(['isActif' => true], ['id' => "DESC"])
        ]);
    }

    public function valeur(): Response
    {
        return $this->render('frontend/valeur.html.twig',[
            'valeur' => $this->valeurRepository->findOneBy(['isActif' => true], ['id' => "DESC"])
        ]);
    }

    public function accueil_presentation($string): Response
    {
        $entity = match ($string){
            'accueil_mission' => $this->missionRepository->findOneBy(['isActif' => true],['id' => 'DESC']),
            'accueil_vision' => $this->visionRepository->findOneBy(['isActif' => true],['id' => 'DESC']),
            default => $this->valeurRepository->findOneBy(['isActif' => true], ['id' => "DESC"]),
        };
        return $this->render('frontend/_accueil_mission.html.twig',[
            'entity' => $entity
        ]);
    }

    public function illustration()
    {
        return $this->render('frontend/illustration.html.twig',[
            'illustration' => $this->accueilAproposRepository->findOneBy(['isActif' => true], ['id' => "DESC"]),
        ]);
    }

    private function footer()
    {
        return $this->render('frontend/_footer_apropos.html.twig',[
            'presentation' => $this->footerAproposRepository->findOneBy([],['id' => "DESC"])
        ]);
    }
}
