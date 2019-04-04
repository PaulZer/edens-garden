<?php

namespace App\Form;

use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantType extends AbstractType
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
            ->add('latinName', TextType::class, [
                'label' => 'Sélectionnez un nom latin :',
                'attr' => ['maxlength' => 80]
            ])
            ->add('picturePath', FileType::class, [
                'label' => 'Sélectionnez une image :',
            ])
            ->add('plantFamily', EntityType::class, [
                'label' => 'Sélectionnez une famille :',
                'class' => PlantFamily::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
        

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plant::class,
        ]);
    }
}