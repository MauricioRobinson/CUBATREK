<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
 
class FormTemp extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('precio', MoneyType::class)
                ->add('rebaja',  MoneyType::class )
                ->add('inicio', DateType::class)
                ->add('fin', DateType::class )
                ->add('save', SubmitType::class, ['label' => 'Crear Hotel']);
    }
}
