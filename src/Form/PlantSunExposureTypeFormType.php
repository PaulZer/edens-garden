<?php

namespace App\Form;

use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantSunExposureType;
use App\Entity\Plant\SunExposureType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantSunExposureTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $plant = $options['attr']['plant'];
        $builder
            ->add('plant', ChoiceType::class, [
                'choices' => [
                    $plant
                ],
                'choice_label' => function(Plant $plant) {
                    return strtoupper($plant->getName());
                },
                'choice_attr' => function(Plant $plant) {
                    return ['class' => 'plant_'.strtolower($plant->getName())];
                }
            ])
            ->add('sunExposureType', EntityType::class, [
                'label' => 'Type d\'ensolleillement :',
                'class' => SunExposureType::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('efficiency', NumberType::class, [
                'label' => 'Efficacité : (%)',
                'attr' => [
                    'min' => 1,
                    'max' => 100,
                    'class' => 'form-control form-control-sm'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlantSunExposureType::class,
        ]);
    }
}
