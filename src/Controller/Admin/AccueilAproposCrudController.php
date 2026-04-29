<?php

namespace App\Controller\Admin;

use App\Entity\AccueilApropos;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccueilAproposCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccueilApropos::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-5'),
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            ImageField::new('media', "Illustration ")
                ->setBasePath('uploads/apropos/')
                ->setUploadDir('public/uploads/apropos/'),
            BooleanField::new('isActif', 'Actif')->setRequired(false)
        ];
    }

}
