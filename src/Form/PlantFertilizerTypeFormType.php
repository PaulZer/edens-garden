<?php

namespace App\Form;

use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFertilizerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantFertilizerTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plant', EntityType::class, [
                'class' => Plant::class,
                'choice_label' => 'name'
            ])
            ->add('fertilizer', EntityType::class, [
                'class' => FertilizerType::class,
                'choice_label' => 'name'
            ])
            ->add('efficiency')
            ->add('nbDayBeforeFertilizing')

            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlantFertilizerType::class,
        ]);
    }
}
