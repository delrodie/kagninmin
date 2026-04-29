<?php

namespace App\Controller\Admin;

use App\Entity\Apropos;
use App\Repository\AproposRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class AproposCrudController extends AbstractCrudController
{
    public function __construct(
        private AproposRepository $aproposRepository,
        private AdminUrlGenerator $adminUrlGenerator,

    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Apropos::class;
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $vision = $this->aproposRepository->findOneBy([]);
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
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('contenu')
                ->setTemplatePath('admin/fields/apropos_details.html.twig'),

            FormField::addColumn('col-md-4 col-lg-3 offset-md-2 offset-lg-3 mt-3'),
            ImageField::new('media1', "Illustration 1")
                ->setBasePath('uploads/apropos/')
                ->setUploadDir('public/uploads/apropos/'),

            FormField::addColumn('col-md-4 col-lg-3 mt-3'),
            ImageField::new('media2', "Illustration 2")
                ->setBasePath('uploads/apropos/')
                ->setUploadDir('public/uploads/apropos/'),

            FormField::addColumn('col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-3'),
            BooleanField::new('isActif', 'Actif')->setRequired(false)
        ];
    }

}
