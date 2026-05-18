<?php

declare(strict_types=1);

namespace App;

use App\Repository\CoordonneeRepository;
use App\Repository\FooterAproposRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/footer', name: 'app_footer')]
class FooterController extends AbstractController
{

    public function __invoke(
        FooterAproposRepository $aproposRepository,
        CoordonneeRepository $coordonneeRepository,
        CacheInterface $cache
    ): Response
    {
        $coordonnee = $cache->get('footer_coordonnee', function (ItemInterface $item) use ($coordonneeRepository) {
            $item->expiresAfter(2592000); // 30 jours
//            $item->tag(['footer', 'coordonnee']);
            return $coordonneeRepository->findOneBy([],['id' => "DESC"]);
        });

        $presentation = $cache->get('footer_presentation', function (ItemInterface $item) use ($aproposRepository){
            $item->expiresAfter(2592000);
//            $item->tag(['footer', 'apropos']);
            return $aproposRepository->findOneBy([],['id' => "DESC"]);
        });
        return $this->render('frontend/footer.html.twig',[
            'coordonnee' => $coordonnee,
            'presentation' => $presentation,
        ]);
    }
}
