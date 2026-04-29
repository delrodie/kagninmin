<?php

namespace App\Controller\Admin;

use App\Entity\Vision;
use App\Repository\VisionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use Symfony\Component\HttpFoundation\Response;

class VisionCrudController extends AbstractCrudController
{
    public function __construct(
        private VisionRepository $visionRepository,
        private AdminUrlGenerator $adminUrlGenerator,
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Vision::class;
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $vision = $this->visionRepository->findOneBy([]);
        if (!$vision) {
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
            ->setEntityId($vision->getId())
            ->generateUrl());
    }

    public function configureActions(Actions $actions): Actions
    {
        $hasRecord = $this->visionRepository->count([]) > 0;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('contenu')
                ->setTemplatePath('admin/fields/vision_details.html.twig')
            ,
            BooleanField::new('isActif', 'Actif')->setRequired(false)
        ];
    }
}
