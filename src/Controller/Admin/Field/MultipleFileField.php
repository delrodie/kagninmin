<?php

namespace App\Controller\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class MultipleFileField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, string|\Symfony\Contracts\Translation\TranslatableInterface|bool|null $label = null): self
    {
        return new self()
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(FileType::class)
            ->setFormTypeOptions([
                'multiple' => true,
                'data_class' => null,
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ]);
    }
}
