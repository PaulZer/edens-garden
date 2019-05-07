<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 11/04/2019
 * Time: 15:04
 */

namespace App\Form;


use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Util\Month;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantPlantingDateIntervalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('climaticArea', EntityType::class, [
                'label' => 'Zone climatique : ',
                'class' => ClimaticArea::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('monthBegin', EntityType::class, [
                'label' => 'Mois de début : ',
                'class' => Month::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('monthEnd', EntityType::class, [
                'label' => 'Mois de fin : ',
                'class' => Month::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlantingDateInterval::class,
        ]);
    }
}