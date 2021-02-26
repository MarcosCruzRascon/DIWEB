<?php

namespace App\Form;

use App\Entity\Categorias;
use App\Entity\Productos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;

class ProductosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('cantidadalmacen')
            ->add('precio')
            //->add('categoria')
            ->add('categoria', EntityType::class, [
                // looks for choices from this entity
                'class' => Categorias::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'nombre',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('imagenes', FileType::class, [
                "label" => "Illustrations (optionnel)",
                "multiple" => true,
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new All([
                        new File([
                            "maxSize" => "10024K",
                            "mimeTypes" => [
                                "image/png",
                                "image/jpg",
                                "image/jpeg",
                                "image/gif"
                            ],
                            "mimeTypesMessage" => "Envíe una imagen en formato png, jpg, jpeg o gif, hasta 10 megabytes"
                        ])
                    ])
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Productos::class,
        ]);
    }
}
