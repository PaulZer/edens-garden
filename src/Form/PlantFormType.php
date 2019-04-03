<?php

namespace App\Form;

use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantingDateInterval;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('latinName')
            ->add('waterFrequency')
            ->add('plantFamily', EntityType::class, [
                'class' => PlantFamily::class,
                'choice_label' => 'name'
            ])
            ->add('plantingDateIntervals', EntityType::class, [
                'class' => PlantingDateInterval::class,
                'choice_label' => 'id'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plant::class,
        ]);
    }
}
