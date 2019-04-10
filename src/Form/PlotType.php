<?php

namespace App\Form;

use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlotType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->setMethod('')
            ->add('name', TextType::class, [
                'label' => 'Choisissez un nom :',
                'attr' => ['maxlength' => 80]
            ])
            ->add('sunExposureType', EntityType::class, [
                'label' => 'Type d\'exposition au soleil :',
                'class' => SunExposureType::class,
                'choice_label' => 'name',
                'empty_data' => null,
            ])
            ->add('soilType', EntityType::class, [
                'label' => 'Type de terre :',
                'class' => SoilType::class,
                'choice_label' => 'name',
                'empty_data' => null,
            ])
            ->add('garden', EntityType::class, [
                'label' => 'Type de terre :',
                'class' => Garden::class,
                'choice_label' => 'name',
                'empty_data' => null,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);


    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plot::class,
        ]);
    }
}