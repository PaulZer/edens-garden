<?php

namespace App\Form;

use App\Entity\Garden\Garden;
use App\Entity\Util\Country;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GardenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->setMethod('')
            ->add('name', TextType::class, [
                'attr' => ['maxlength' => 80]
            ])
            ->add('latitude', NumberType::class, [
                'scale' => 6,
                'attr' => [
                    'min' => -90,
                    'max' => 90
                    ]
            ])
            ->add('longitude', NumberType::class, [
                'scale' => 6,
                'attr' => [
                    'min' => -180,
                    'max' => 180
                ]
            ])
            ->add('height', IntegerType::class, [
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_DOWN,
                'attr' => ['min' => 1, 'max' => 20]
            ])
            ->add('length', IntegerType::class, [
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_DOWN,
                'attr' => ['min' => 1, 'max' => 20]
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Garden::class,
        ]);
    }
}