<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\MultipleFileField;
use App\Entity\Actualite;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('domaine'),
            TextField::new('titre'),
            TextEditorField::new('contenu'),
            DateField::new('dateAction', "Date d'action"),

            ImageField::new('media', "Photo de couverture")
                ->setBasePath('uploads/actualites/')
                ->setUploadDir('public/uploads/actualites/'),

            BooleanField::new('isAtif', 'Est actif')->renderAsSwitch(),

            // Upload multiple en une seule fois
            MultipleFileField::new('photosFiles')
                ->setLabel('Photos (plusieurs à la fois)')
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'multiple' => true,
                    'attr' => ['accept' => 'image/*'],
                ]),

            // Affichage des photos existantes
            CollectionField::new('photos')
                ->setEntryIsComplex(true)
                ->onlyOnDetail()
                ->renderExpanded(),

            // Ou ImageField si vous voulez juste voir les miniatures
            // ImageField::new('photos') n'est pas direct sur collection, mieux utiliser le CollectionField
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handlePhotoUploads($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handlePhotoUploads($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handlePhotoUploads(Actualite $actualite): void
    {
        $files = $actualite->getPhotosFiles();
        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) continue;

            $photo = new Photo();
            $photo->setActualite($actualite);
            $photo->setMedia($this->uploadFile($file)); // voir ci-dessous
            $photo->setLegende(''); // ou demander dans un form plus avancé

            $actualite->addPhoto($photo);
        }

        // On vide le champ virtuel
        $actualite->setPhotosFiles(null);
    }

    private function uploadFile(UploadedFile $file): string
    {
        $uploadDir = date('Y/m');
        $filename = uniqid() . '.' . $file->guessExtension();

        $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/photos/' . $uploadDir, $filename);

        return $uploadDir . '/' . $filename;
    }

}
