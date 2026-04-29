<?php

namespace App\Controller\Admin;

use App\Entity\Partenaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartenaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partenaire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            FormField::addColumn('col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-5'),
            TextField::new('nom', 'Nom du partenaire')
                ->setFormTypeOptions([
                    'attr' => ['autocomplete' => "off"]
                ]),
            ImageField::new('media', "Logo du partenaire")
                ->setBasePath('uploads/partenaires/')
                ->setUploadDir('public/uploads/partenaires/'),
            BooleanField::new('isActif', 'Actif')->setRequired(false)
        ];
    }

}
