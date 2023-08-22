<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre de la recette",
                "attr" => [
                    "placeholder" => "Titre"
                ]
            ])
            ->add('picture', UrlType::class,[
                "label" => "Url de l'image",
                "attr" => [
                    "placeholder" => "http::// ...."
                ]
            ])
            // ! voir affichage des steps
            ->add('steps', CollectionType::class, [
                'prototype' => true,
                "label" => "Etapes de la recette",
                "attr" => [
                    "placeholder" => "....."
                ],
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])

            ->add('status', ChoiceType::class, [
                "label" => "Statut",
                "choices" => [
                    "Privé" => "Privé",
                    "Public" => "Public"
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('duration', IntegerType::class, [
                "label" => "Temps de préparation",
                "attr" => [
                    "placeholder" => "30 mn"
                ],
                "help" => "* temps en minutes"
            ])
            // ! voir affichage des ingredients
            ->add('ingredients')
            ->add('category', EntityType::class, [
                'class'=> Category::class,
                "choice_label" => "title",
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
