<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Entrez votre Prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Entrez votre Nom"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "placeholder" => "Entrez votre mail"
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" => "Veuillez accepter les conditions générales d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "You should agree to our terms.",
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'first_options' => [
                    'label' => "Mot de passe",
                    'mapped' => false,
                    'attr' => [
                         'autocomplete' => 'new-password',
                         "placeholder" => "Entrez votre mot de passe",
                         "tabindex" => 0,
                     ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 8,
                            //'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 16,
                        ]),
                        // = https://symfony.com/doc/5.4/reference/constraints/Regex.html
                        new Regex([
                            'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/',
                            'message' => 'Votre mot de passe "{{ value }}" n\'est pas sécurisé',
                        ])
                    ],
                    "help" => "Le mot de passe doit contenir entre 8 et 16 caractères, avec une majuscule, une minuscule et caractère spécial"
                ], 
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        "placeholder" => "Entrez à nouveau votre mot de passe",
                        'minlength' => 8,
                        'maxlength' => 16,
                        "tabindex" => 0,
                    ],
                    'label' => 'Répéter',
                    
                ],
                'invalid_message' => 'Les mots de passe saisis ne sont pas identiques.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
