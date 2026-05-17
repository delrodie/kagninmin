<?php

namespace App\EventListener;

use App\Entity\PageView;
use Doctrine\ORM\EntityManagerInterface;
use GeoIp2\Database\Reader;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class PageViewListener
{
    private ?Reader $geoReader = null;

    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private string $geoDbPath
    ) {
        if (file_exists($geoDbPath)) {
            $this->geoReader = new Reader($geoDbPath);
        }
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->getRequestType() !== HttpKernelInterface::MAIN_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // Exclusions
        if (str_starts_with($path, '/build') ||
            str_starts_with($path, '/admin') ||
            str_starts_with($path, '/qui-sommes-nous/accueil_mission') ||
            str_starts_with($path, '/qui-sommes-nous/accueil_vision') ||
            str_starts_with($path, '/qui-sommes-nous/accueil_valeur') ||
            str_starts_with($path, '/qui-sommes-nous/illustration') ||
            str_starts_with($path, '/qui-sommes-nous/vision') ||
            str_starts_with($path, '/qui-sommes-nous/mission') ||
            str_starts_with($path, '/qui-sommes-nous/valeur') ||
            str_starts_with($path, '/qui-sommes-nous/apropos') ||
            str_starts_with($path, '/partenaires') ||
            str_starts_with($path, '/contact/footer') ||
            str_starts_with($path, '/backend') ||
            str_starts_with($path, '/_') ||
            $path === '/favicon.ico') {
            return;
        }

        // Exclure les administrateurs et utilisateurs connectés
        if ($this->security->getUser()) {
            return;
        }

        $ip = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');
        $visitorHash = hash('xxh3', $ip . $userAgent);

        $view = new PageView();
        $view->setPath($path);
        $view->setReferrer($request->headers->get('referer'));
        $view->setIp(substr($ip, 0, strrpos($ip ?? '', '.')) . '.xxx');
        $view->setUserAgent($userAgent);
        $view->setVisitorHash($visitorHash);

        // Géolocalisation
        if ($this->geoReader && $ip) {
            try {
                $record = $this->geoReader->country($ip);
                $view->setCountryCode($record->country->isoCode);
                $view->setCountryName($record->country->name);
            } catch (\Exception $e) {}
        }

        $this->em->persist($view);
        $this->em->flush();
    }
}
