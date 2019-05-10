<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GardenPlantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->setAction($options['action'])
            ->setMethod('')
            ->add('name', TextType::class, [
                'label' => 'Choisissez un nom :',
                'attr' => ['maxlength' => 80]
            ]);

    }
}