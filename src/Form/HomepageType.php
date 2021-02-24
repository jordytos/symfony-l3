<?php

namespace App\Form;

use App\Entity\Homepage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,[
                'label' => 'Titre'
            ])
            ->add('body',null,[
                'label' => 'Description'
            ])
            ->add('titleAbout',null,[
                'label' => 'A propos'
            ])
            ->add('textAbout',null,[
                'label' => 'Informations supplémentaires'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Homepage::class,
        ]);
    }
}
