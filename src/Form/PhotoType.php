<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('legende', TextType::class, [
                'label' => 'Légende',
                'required' => false,
            ])
            ->add('mediaFile', FileType::class, [   // champ virtuel pour l'upload
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
//                'constraints' => [
//                    new Image(['maxSize' => '10M'])
//                ],
                'attr' => ['accept' => 'image/*'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
