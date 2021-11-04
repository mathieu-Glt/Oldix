<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Thematic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Name of the movie'
            ])
            ->add('link',TextType::class,[
                'label'=>'Link of the movie',
                'attr'=>[
                    'placeholder'=>'https://www.linktopicture.jpg'
                ]
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => "name"
            ])
            ->add('thematics', EntityType::class, [
                'class' => Thematic::class,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true,
            ])  
            ->add('categories', EntityType::class, [
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
