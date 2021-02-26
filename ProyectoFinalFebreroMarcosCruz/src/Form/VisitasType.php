<?php

namespace App\Form;

use App\Entity\Visitas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaHora')
            ->add('motivo')
            ->add('problemasencontrados')
            ->add('soluciones')
            ->add('realizada')
            ->add('agenda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visitas::class,
        ]);
    }
}
