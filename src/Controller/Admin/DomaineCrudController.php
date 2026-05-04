<?php

namespace App\Controller\Admin;

use App\Entity\Domaine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DomaineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Domaine::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-5'),
            IdField::new('id')->hideOnForm(),
            TextField::new('titre')->setRequired(true),
            TextEditorField::new('contenu')->setRequired(true),
            ImageField::new('media', "Illustration")
                ->setBasePath('uploads/domaine/')
                ->setUploadDir('public/uploads/domaine/')
                ->setRequired(false),
            BooleanField::new('isActif', 'Actif')->setRequired(false),
        ];
    }

}
