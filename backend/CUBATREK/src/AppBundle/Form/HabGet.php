<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HabGet extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('tipo', TextType::class)
                ->add('pax', IntegerType::class)
                ->add('politica', TextareaType::class)
                ->add('observacion', TextareaType::class )
                ->add('disponibilidad',  IntegerType::class )
                ->add('save', SubmitType::class, ['label' => 'Crear Habitacion']);
    }
}
