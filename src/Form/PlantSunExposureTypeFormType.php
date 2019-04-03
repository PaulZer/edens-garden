<?php

namespace App\Form;

use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantSunExposureType;
use App\Entity\Plant\SunExposureType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantSunExposureTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plant', EntityType::class, [
                'class' => Plant::class,
                'choice_label' => 'name'
            ])
            ->add('sunExposureType', EntityType::class, [
                'class' => SunExposureType::class,
                'choice_label' => 'name'
            ])
            ->add('efficiency')
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
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
