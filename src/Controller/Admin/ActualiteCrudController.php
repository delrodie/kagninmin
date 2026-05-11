<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\MultipleFileField;
use App\Entity\Actualite;
use App\Entity\Photo;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Attribute\Route;

class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Ajoute le lien "Voir" / "Détail" dans la liste
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            // Option : mettre le détail en action principale au clic sur une ligne
            //->setDefaultRowAction(Action::DETAIL)   // ou Action::EDIT si tu préfères
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            FormField::addColumn('col-md-6 col-lg-5 mt-5'),
            AssociationField::new('domaine'),
            TextField::new('titre'),
            DateField::new('dateAction', "Date d'action"),

            ImageField::new('media', "Photo de couverture")
                ->setBasePath('uploads/actualites/')
                ->setUploadDir('public/uploads/actualites/'),

            BooleanField::new('isAtif', 'Est actif')->renderAsSwitch(),

            FormField::addColumn('col-md-6 col-lg-7 mt-5'),
            TextEditorField::new('contenu')
                ->onlyOnForms(),
            TextEditorField::new('contenu')
                ->setTemplatePath('admin/fields/apropos_details.html.twig')
                ->onlyOnDetail(),

            // Upload multiple en une seule fois
            MultipleFileField::new('photosFiles')
                ->setLabel('Ajouter de nouvelles photos (plusieurs à la fois)')
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'multiple' => true,
                    'attr' => ['accept' => 'image/*'],
                ]),

            FormField::addColumn('col-md-12 mt-5'),
            CollectionField::new('photos')
                ->setLabel('Photos de l\'actualité')
                ->setEntryIsComplex(true)
                ->onlyOnDetail()
                ->renderExpanded()
                ->setTemplatePath('admin/fields/photos_detail.html.twig'),

            // Ou ImageField si vous voulez juste voir les miniatures
            // ImageField::new('photos') n'est pas direct sur collection, mieux utiliser le CollectionField
        ];
    }

    // Dans un contrôleur ou dans ActualiteCrudController
    #[Route('/backend/photo/{id}/delete', name: 'app_admin_actualite_delete_photo', methods: ['GET','POST'])]
    public function deletePhoto(
        Photo $photo,
        EntityManagerInterface $em,
        \Symfony\Component\HttpFoundation\Request $request
    ): \Symfony\Component\HttpFoundation\RedirectResponse
    { //dd($request->query->get('_token'));
        // Vérification CSRF
        if (!$this->isCsrfTokenValid('delete_photo_' . $photo->getId(), $request->query->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $actualiteId = $photo->getActualite()?->getId();

        if ($photo->getActualite()) {
            $em->remove($photo);
            $em->flush();
        }

        $this->addFlash('success', 'Photo supprimée avec succès.');

        return $this->redirectToRoute('app_admin_actualite_detail', [
//            'crudAction' => 'detail',
//            'crudControllerFqcn' => ActualiteCrudController::class,
            'entityId' => $actualiteId,
        ]);
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
            if (!$file instanceof UploadedFile || $file->getError() !== UPLOAD_ERR_OK) continue;

            $photo = new Photo();
            $photo->setActualite($actualite);
            $photo->setMedia($this->uploadFile($file)); // voir ci-dessous
            $photo->setLegende($actualite->getTitre()); // ou demander dans un form plus avancé

            $actualite->addPhoto($photo);
        }

        // On vide le champ virtuel
        $actualite->setPhotosFiles(null);
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
