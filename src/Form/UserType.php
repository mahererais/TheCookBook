<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email",
                "attr" => [
                    "placeholder" => "Entrez votre email"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "nom",
                "attr" => [
                    "placeholder" => "Entrez votre nom"
                ]
            ])
            ->add('firstname', TextType::class, [
                "label" => "prénom",
                "attr" => [
                    "placeholder" => "Entrez votre prénom"
                ]
            ])
            ->add('picture', HiddenType::class, [
                "label" => "Photo de mon profil",
                // unmapped means that this field is not associated to any entity property
                "mapped" => false,
            ])
            ->add('speciality', TextType::class, [
                "label" => "Specialité",
                "attr" => [
                    "placeholder" => "Entrez votre spécialité"
                ]
            ])
            ->add('experience', ChoiceType::class, [
                "label" => "Experience",
                'choices'  => [
                    'Professionnel' => "Professionnel",
                    'Amateur' => "Amateur",
                ],
            ])
            ->add('presentation', TextareaType::class, [
                "label" => "Presentation",
                "attr" => [
                    "placeholder" => "Entrez ici une presentation",
                    "rows" => 5,
                ]
            ])
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
                "attr" => [
                    "placeholder" => "Modifiez votre mot de passe",
                    'autocomplete' => 'current-password',
                    // 'autocomplete' => 'new-password',
                ],
                //'hash_property_path' => 'password', // ! The hash_property_path option was introduced in Symfony 6.2.
                "mapped" => true, // unmapped means that this field is not associated to any entity property
                "required" => true, // make it optional so you don't have to re-upload the PDF file every time you edit user profile
                "help" => "Le mot de passe doit contenir au moins 8 caractéres",
                ])
            ->add('status', ChoiceType::class, [
                "label" => "Status",
                "choices" => [
                    "Private" => "privé",
                    "Public" => "public",
                ],
                "expanded" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
