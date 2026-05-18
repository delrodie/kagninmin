<?php

namespace App\EventListener;

use App\Entity\Coordonnee;
use App\Entity\FooterApropos;   // Change si le nom exact est différent
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsEntityListener(event: Events::postPersist)]
#[AsEntityListener(event: Events::postUpdate)]
#[AsEntityListener(event: Events::postRemove)]
class FooterCacheInvalidatorListener
{
    public function __construct(
        private CacheInterface $cache
    ) {}

    public function __invoke(object $entity): void
    {
        // Vérifie si l'entité modifiée concerne le footer
        if ($entity instanceof Coordonnee || $entity instanceof FooterApropos) {
            $this->invalidateFooterCache();
        }
    }

    private function invalidateFooterCache(): void
    {
        // Si tu utilises les tags (recommandé)
        if ($this->cache instanceof TagAwareCacheInterface) {
            $this->cache->invalidateTags(['footer', 'coordonnee', 'apropos']);
        }
        // Sinon (fallback)
        else {
            $this->cache->delete('footer_coordonnee');
            $this->cache->delete('footer_presentation');
        }
    }
}
