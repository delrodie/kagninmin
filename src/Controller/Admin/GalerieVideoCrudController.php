<?php

namespace App\Controller\Admin;

use App\Entity\GalerieVideo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GalerieVideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GalerieVideo::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-md-6 mt-5'),
            AssociationField::new('domaine')
                ->setRequired(true),
            TextField::new('titre', 'Titre de la vidéo')
                ->setRequired(true),

            FormField::addColumn('col-md-6 mt-5'),
            TextareaField::new('description', "Description de la video")
                ->setRequired(true),

            FormField::addColumn('col-md-3'),
            ImageField::new('cover', "Photo de couverture")
                ->setBasePath('uploads/videos/cover')
                ->setUploadDir('public/uploads/videos/cover')
                ->setRequired(true),

            FormField::addColumn('col-md-3'),
            FileField::new('media', "Vidéo")
                ->mimeTypes('video/*')
                ->setBasePath('uploads/videos/')
                ->setUploadDir('public/uploads/videos/')
                ->setRequired(true),

            FormField::addColumn('col-12'),
            DateField::new('dateAction')
                ->setRequired(true),
            BooleanField::new('isActif'),
        ];
    }

}
