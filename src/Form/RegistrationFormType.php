<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', null, ['label' => "Prénom*", 'attr' => ['placeholder' => 'Prenom'], 'required' => true])

            ->add('nom', null, ['label' => "Nom de famille*", 'attr' => ['placeholder' => 'Nom'], 'required' => true])

            ->add('civilite', null, ['label' => "Civilité*", 'attr' => ['placeholder' => 'Civilité'], 'required' => true])

            ->add('datenaissance', BirthdayType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'mois', 'day' => 'jour'
                ],
                'required' => true
            ])

            ->add('email', EmailType::class, ['label' => "Email*", 'attr' => ['placeholder' => 'Ex : email@email.com'], 'required' => true])

            ->add('telephone', null, ['label' => "Téléphone", 'attr' => ['placeholder' => 'Numéro de téléphone'], 'required' => false])

            ->add('ville', null, ['label' => "Ville", 'attr' => ['placeholder' => 'Ex : Tours'], 'required' => false])

            ->add('codepostal', null, ['label' => "Code postal", 'attr' => ['placeholder' => 'Ex : 37000'], 'required' => false])

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

            ->add('numsecu', null, ['label' => "Numéro de sécurité sociale", 'required' => false])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
