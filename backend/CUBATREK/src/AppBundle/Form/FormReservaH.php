<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormReservaH extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('fechaEntrada', DateType::class,['widget'=>'single_text','label' => 'Entrada'])
                ->add('fechaSalida', DateType::class,['widget'=>'single_text','label' => 'Salida'])
                ->add('cantHabitaciones', ChoiceType::class,[
                    'choices'=>[
                        
                        '-'=>0,
                        '1'=>1,
                        '2'=>2,
                        '3'=>3,
                        '4'=>4,
                        '5'=>5,
                        '6'=>6,
                    ]
                ,'label' => 'Habitaciones'])
                ->add('adultos', ChoiceType::class,[
                    'choices'=>[
                        
                        '-'=>0,
                        '1'=>1,
                        '2'=>2,
                        '3'=>3,
                        '4'=>4,
                        '5'=>5,
                        '6'=>6,
                    ]
                ])
                ->add('ninos', ChoiceType::class,[
                    'choices'=>[
                        
                        '-'=>0,
                        '1'=>1,
                        '2'=>2,
                        '3'=>3,
                        '4'=>4,
                        '5'=>5,
                        '6'=>6,
                    ]
                ,'label' => 'Niños'])
                ->add('infantes', ChoiceType::class,[
                    'choices'=>[
                        
                        '-'=>0,
                        '1'=>1,
                        '2'=>2,
                        '3'=>3,
                        '4'=>4,
                        '5'=>5,
                        '6'=>6,
                    ]
                ])
                ->add('nombre', TextType::class)
                ->add('apellido', TextType::class)
                ->add('correo', EmailType::class,['label' => 'Email'])
                ->add('mensaje',TextareaType::class,['label' => 'Mensaje (Opcional)','required'=> false])
                ->add('token', HiddenType::class,['data' => 'abcdef','mapped'=>false])
                ->add('save', SubmitType::class, ['label' => '200']);
    }
}
