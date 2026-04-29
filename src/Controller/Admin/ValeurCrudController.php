<?php

namespace App\Controller\Admin;

use App\Entity\Valeur;
use App\Repository\ValeurRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class ValeurCrudController extends AbstractCrudController
{
    public function __construct(
        private ValeurRepository $valeurRepository,
        private AdminUrlGenerator $adminUrlGenerator,

    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Valeur::class;
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $vision = $this->valeurRepository->findOneBy([]);
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
        $hasRecord = $this->valeurRepository->count([]) > 0;
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
                ->setTemplatePath('admin/fields/mission_details.html.twig'),
            BooleanField::new('isActif', 'Actif')->setRequired(false)
        ];
    }

}
