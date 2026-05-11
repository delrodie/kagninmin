<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        //$actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        $actions->disable(Action::NEW);

        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            AssociationField::new('Actualite'),
            ImageField::new('media', "Illustration")
                ->setBasePath('uploads/photos/')
                ->setUploadDir('public/uploads/photos/'),
            TextField::new('legende'),
//            TextEditorField::new('description'),
        ];
    }

}
