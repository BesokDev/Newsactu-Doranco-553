<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Nouveau mot de passe'
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Répétez le mot de passe'
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Changer',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block mx-auto col-3 my-3 btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
