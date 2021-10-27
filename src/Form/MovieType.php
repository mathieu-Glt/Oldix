<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Thematic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('link')
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => "name"
            ])
            ->add('thematic', EntityType::class, [
                'class' => Thematic::class,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
