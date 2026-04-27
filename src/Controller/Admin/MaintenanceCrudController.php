<?php

namespace App\Controller\Admin;

use App\Entity\Maintenance;
use App\Repository\MaintenanceRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaintenanceCrudController extends AbstractCrudController
{
    public function __construct(private MaintenanceRepository $maintenanceRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Maintenance::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->addFormTheme('@EasyAdmin/crud/form_theme.html.twig')
            ->setPageTitle(Crud::PAGE_EDIT, 'Maintenance')
            ->setPageTitle(Crud::PAGE_NEW, 'Maintenance');
    }

    public function configureActions(Actions $actions): Actions
    {
        $hasRecord = $this->maintenanceRepository->count([]) > 0;
        if ($hasRecord){
            $actions->disable(Action::NEW);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            BooleanField::new('isActif', 'Est activé')
                ->setColumns('col-12 col-md-4 offset-md-4 mt-5')
                ->setFormTypeOptions([
                    'row_attr' => [
                        'class' => 'text-center justify-content-center',
                    ],
                    'label_attr' => [
                        'class' => 'justify-content-center',
                    ],
                ]),
        ];
    }
}
