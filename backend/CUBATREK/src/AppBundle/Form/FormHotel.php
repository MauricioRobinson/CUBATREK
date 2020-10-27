<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class FormHotel extends AbstractType {
   public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('nombre', TextType::class)
                ->add('categoria', RangeType::class,['attr' => ['min' => 1,'max' => 5]])
                ->add('cadena', TextType::class)
                ->add('region', TextType::class )
                ->add('save', SubmitType::class, ['label' => 'Crear Hotel']);
    }
}
