<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class UserType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nom',null, [
                'required' => true,
                'label' => 'Nom'
        ])
            ->add('prenom',null, [
                'required' => true,
                'label' => 'prénom'
        ])

            ->add('email',null, [
                'required' => true,
                'label' => 'Email'
        ])
            ->add('civilite',null, [
                'required' => true,
                'label' => 'Civilité'
        ])
            ->add('datenaissance',BirthdayType::class, [
                'required' => true,
                'label' => 'Date de naissance'
        ])
            ->add('telephone',null, [
                'required' => false,
                'label' => 'Téléphone'
        ])
            ->add('Ville',null, [
                'required' => false,
                'label' => 'Ville'
        ])
            ->add('codepostal',null, [
                'required' => false,
                'label' => 'Code Postal'
        ])
            ->add('pays', CountryType::class, [
                'required' => false,
                'preferred_choices' => ['DE'],
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'address.form.country.placeholder'
                ],
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ],
            ])
            ->add('numsecu',null, [
                'required' => false,
                'label' => 'Numéro de sécu'
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
