<?php

namespace App\Controller\Admin;

use App\Entity\Coordonnee;
use App\Repository\CoordonneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CoordonneeCrudController extends AbstractCrudController
{
    public function __construct(
        private CoordonneeRepository $coordonneeRepository,
        private AdminUrlGenerator $adminUrlGenerator,
        private CacheInterface $cache,           // ← Injection
        private EntityManagerInterface $entityManager
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Coordonnee::class;
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $coordonnee = $this->coordonneeRepository->findOneBy([]);
        if (!$coordonnee) {
            return $this->redirect(
                $this->adminUrlGenerator
                    ->setController(self::class)
                    ->setAction(Action::NEW)
                    ->generateUrl()
            );
        }

        return $this->redirect($this->adminUrlGenerator
            ->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($coordonnee->getId())
            ->generateUrl());
    }

    public function configureActions(Actions $actions): Actions
    {
        $hasRecord = $this->coordonneeRepository->count([]) > 0;
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        if ($hasRecord) {
            $actions->disable(Action::NEW, Action::DELETE);
        }

        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            FormField::addColumn('col-md-5 col-lg-4 offset-md-1 offset-lg-2 mt-5'),
            TextField::new('siege', "Siège social"),
            TextField::new('horaire', "Horaire d'ouverture"),
            EmailField::new('email', 'Adresse email'),
            TelephoneField::new('phone1', "Portable 1"),
            TelephoneField::new('phone3', "Portable 3"),

            FormField::addColumn('col-md-5 col-lg-4 mt-5'),
            TelephoneField::new('telephone', "Telephone"),
            TelephoneField::new('phone2', "Portable 2"),
            UrlField::new('facebook', "Facebook"),
            UrlField::new('instagram', "Instagram"),
            TelephoneField::new('whatsapp', "Numéro WhatsApp"),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        $this->invalidateFooterCache();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        $this->invalidateFooterCache();
    }

    private function invalidateFooterCache(): void
    {
        if ($this->cache instanceof TagAwareCacheInterface) {
            $this->cache->invalidateTags(['footer', 'coordonnee']);
        } else {
            // Fallback si pas de tags
            $this->cache->delete('footer_coordonnee');
        }
    }

}
