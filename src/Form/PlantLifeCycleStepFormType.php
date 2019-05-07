<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 10/04/2019
 * Time: 15:21
 */

namespace App\Form;


use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantLifeCycleStep;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantLifeCycleStepFormType extends AbstractType
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
            ->add('lifeCycleStep', EntityType::class, [
                'label' => 'Etape de cycle de vie : ',
                'class' => LifeCycleStep::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('stepDaysDuration', NumberType::class, [
                'label' => 'Durée de l\'étape : (jours) ',
                'attr' => [
                    'min' => 1,
                    'max' => 100,
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('order', NumberType::class, [
                'label' => 'Ordre de l\'étape : (1-6) ',
                'attr' => [
                    'min' => 1,
                    'max' => 6,
                    'class' => 'form-control form-control-sm'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlantLifeCycleStep::class,
        ]);
    }
}