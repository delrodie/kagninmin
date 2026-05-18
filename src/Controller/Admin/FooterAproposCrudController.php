<?php

namespace App\Controller\Admin;

use App\Entity\FooterApropos;
use App\Repository\FooterAproposRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class FooterAproposCrudController extends AbstractCrudController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
        private readonly FooterAproposRepository $aproposRepository,
        private CacheInterface $cache,           // ← Injection
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return FooterApropos::class;
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $apropos = $this->aproposRepository->findOneBy([]);
        if (!$apropos) {
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
            ->setEntityId($apropos->getId())
            ->generateUrl());
    }

    public function configureActions(Actions $actions): Actions
    {
        $hasRecord = $this->aproposRepository->count([]) > 0;
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        if ($hasRecord) {
            $actions->disable(Action::NEW, Action::DELETE);
        }

        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-5'),
            TextField::new('titre'),
            TextEditorField::new('contenu')
                ->setTemplatePath('admin/fields/vision_details.html.twig'),
            ImageField::new('media', "logo ")
                ->setBasePath('uploads/apropos/')
                ->setUploadDir('public/uploads/apropos/'),
            TextField::new('tags', )
        ];
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        $this->invalidateFooterCache();
    }

    private function invalidateFooterCache(): void
    {
        if ($this->cache instanceof TagAwareCacheInterface) {
            $this->cache->invalidateTags(['footer', 'apropos']);
        } else {
            // Fallback si pas de tags
            $this->cache->delete('footer_presentation');
        }
    }


}
