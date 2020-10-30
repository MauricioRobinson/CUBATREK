<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class FormReservaH extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('nombre', TextType::class)
                ->add('apellido', TextType::class)
                ->add('identidad', TextType::class)
                ->add('fechaEntrada', DateType::class)
                ->add('fechaSalida', DateType::class)
                ->add('pax', IntegerType::class)
                ->add('correo', EmailType::class)
                ->add('save', SubmitType::class, ['label' => 'Crear Habitacion']);
    }
}
