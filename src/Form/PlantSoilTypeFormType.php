<?php

namespace App\Form;

use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantSoilType;
use App\Entity\Plant\SoilType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantSoilTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plant', EntityType::class, [
                'class' => Plant::class,
                'choice_label' => 'name'
            ])
            ->add('soilType', EntityType::class, [
                'class' => SoilType::class,
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
            'data_class' => PlantSoilType::class,
        ]);
    }
}
