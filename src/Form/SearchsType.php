<?php

namespace App\Form;

use App\Entity\Searchs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre',TextType::class,[
                'attr' => [
                    "required" => false
                ]
            ])
            // ->add('genre',TextType::class,[
            //     'attr' => [
            //         "required" => false
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Searchs::class,
        ]);
    }
}
