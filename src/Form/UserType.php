<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            // ->add('roles')
            // ->add('password')
            ->add('firstname', TextType::class, [
                "label" => "nom",
                "attr" => [
                    "placeholder" => "Entrez votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Entrez votre nom"
                ]
            ])
            ->add('picture')
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
                    "placeholder" => "Entrez ici une presentation"
                ]
            ])
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
                "attr" => [
                    "placeholder" => "Entrez votre mot de passe"
                ]
            ])
            ->add('status', ChoiceType::class, [
                "label" => "Status",
                "choices" => [
                    "Private" => "Privé",
                    "Public" => "Public",
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
