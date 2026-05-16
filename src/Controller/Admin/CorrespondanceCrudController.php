<?php

namespace App\Controller\Admin;

use App\Entity\Correspondance;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CorrespondanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Correspondance::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            FormField::addColumn('col-md-6 col-lg-4 offset-md-3 offset-lg-4 mt-5'),
            EmailField::new('email', "Adresse email"),
            BooleanField::new('isActif', "Activé"),
            DateTimeField::new('updatedAt', "Mise a jour")->hideOnForm(),
        ];
    }

}
