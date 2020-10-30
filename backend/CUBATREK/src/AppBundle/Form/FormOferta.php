<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class FormOferta extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('tipo', TextType::class)
                ->add('periodo', DateIntervalType::class,['input'  => 'string'])
                ->add('fechaLimite', DateType::class)
                ->add('save', SubmitType::class, ['label' => 'Crear Hotel']);
    }
}
