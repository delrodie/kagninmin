<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Objet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom & prenoms',
                'attr' => ['class' => 'form-control', 'autocomplete' => "off"],
                'label_attr' => ['class' => 'sr-only form-label'],
            ])
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => "off"],
                'label' => "Votre adresse email",
                'label_attr' => ['class' => 'sr-only form-label'],
            ])
            ->add('contenu', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'rows' => 5, 'cols' => 30],
                'label_attr' => ['class' => 'sr-only form-label'],
                'label' => "Message"
            ])
            ->add('objet', EntityType::class, [
                'class' => Objet::class,
                'choice_label' => 'titre',
                'attr' => ['class' => "form-control"],
                "label" => "Objet",
                'label_attr' => ['class' => 'sr-only form-label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
