<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Category name',
                'attr' => [
                    'placeholder' => 'Enter category name'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Category description',
                'attr' => [
                    'placeholder' => 'Enter description'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Category image',
                'required' => false,
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save category',
                'attr' => [
                    'class' => 'btn btn-success float-left mx-2'
                ]
            ])
            ->add('delete', SubmitType::class, [
                'label' => 'Delete category',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
