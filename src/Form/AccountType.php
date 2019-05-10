<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;

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
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
    }
}