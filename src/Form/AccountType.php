<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->setAction($options['action'])
            ->setMethod('')
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'maxlength' => 80,
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'maxlength' => 80,
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'type' => 'email'
                ]
            ])
            ->add('wantFeedBack', CheckboxType::class, [
                'label'    => 'Notifications mail',
                'required' => false
            ])
            ->add('days_between_feedback', ChoiceType::class, [
                'label'    => 'Nombre de jours entre nofifications',
                'choices'  => [
                    'Sélectionnez' => 0,
                    '1 jour' => 1,
                    '3 jours' => 3,
                    '5 jours' => 5,
                    '7 jours' => 7,
                ],
                'empty_data' => 0
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => false,
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmation'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
    }
}