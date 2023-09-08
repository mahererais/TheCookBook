<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre de votre recette",
                "attr" => [
                    "placeholder" => "Titre"
                ]
            ])
            ->add('category', EntityType::class, [
                'class'=> Category::class,
                "choice_label" => "title",
                "label" => "Catégorie"
            ])
            ->add('picture', HiddenType::class,[
                "label" => "Photo de la recette",
                // unmapped means that this field is not associated to any entity property
                "mapped" => false,
            ])

            ->add('ingredients', CollectionType::class, [
                'entry_type' => TextType::class,
                "label" => "Ingrédients de la recette",
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Length([
                        'min' => 0,
                        'minMessage' => 'Veuillez au moins saisir un ingrédient'
                    ])
                ],
                "help" => "Saisir au moins un ingrédient",
            ])
           
            ->add('steps', CollectionType::class, [
                'entry_type' => TextType::class,
                "label" => "Etapes de préparation de votre recette",
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Veuillez saisir une étape'
                    ])
                ],
                "help" => "Saisir au moins une étape"
            ])
            ->add('duration', IntegerType::class, [
                "label" => "Temps de préparation",
                "attr" => [
                    "placeholder" => "30 mn"
                ],
                "help" => "* en minutes"
            ])
            ->add('status', ChoiceType::class, [
                "label" => "Statut de la recette",
                "choices" => [
                    "Privé" => "privé",
                    "Public" => "public"
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('ebook', ChoiceType::class, [
                "label" => "Voulez vous ajouter cette recette à votre Ebook ?",
                "choices" => [
                    "Oui" => 1,
                    "Non" => 0
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'tcb_btn'
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
