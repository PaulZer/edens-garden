<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/05/2019
 * Time: 15:02
 */

namespace App\Form;


use App\Entity\Garden\Plot;
use App\Entity\Plant\Plant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AddPlantToPlotFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('plant', EntityType::class, [
                'label' => 'Choisir une plante : ',
                'class' => Plant::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('plot', EntityType::class, [
                'label' => 'Choisir une parcelle : ',
                'class' => Plot::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }
}