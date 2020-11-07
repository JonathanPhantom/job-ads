<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Form\FormConfig;
use App\Entity\Localites;
use Symfony\Component\Form\AbstractType;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompteCandidatType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration(null, '', [
                'attr' => [
                    'class' => 'form-control rounded-0 ',
                    'placeholder' => 'Nom'
                ],
                'label' => false
            ]))
            ->add('prenom', TextType::class, $this->getConfiguration('', '', [
                'attr' => [
                    'class' => 'form-control rounded-0 ',
                    'placeholder' => 'Prénom'
                ],
                'label' => false
            ]))
            ->add('email', EmailType::class, $this->getConfiguration('', '', [
                'attr' => [
                    'class' => 'form-control rounded-0 ',
                    'placeholder' => 'Adresse email'
                ],
                'label' => false
            ]))
            ->add('dateNaissance', DateType::class, $this->getConfiguration('', 'Date de naissance', [
                'attr' => [
                    'class' => 'form-control rounded-0 ',
                ],
                'label' => false,
                'widget' => 'single_text'
            ]))
            ->add('telephone', TelType::class, $this->getConfiguration('', '', [
                'attr' => [
                    'class' => 'form-control rounded-0 ',
                    'placeholder' => 'Téléphone'
                ],
                'label' => false,
                'required' => false
                ]))
                ->add('adresse', TextType::class, $this->getConfiguration('', 'Veuillez saisir votre adresse', [
                    'label' => false
                    ]))
                ->add('localite', EnumType::class, $this->getConfiguration('Localité / Ville', '', [
                        'attr' => [
                            'class' => 'custom-select rounded-0'
                        ],
                        'enum_class' => Localites::class
                        ]))
            // ->add('disponibilite', ChoiceType::class, $this->getConfiguration('', '', [
            //     'choices' => [
            //         'Je ne suis pas encore disponible' => false,
            //         'Je suis disponible' => true
            //     ],

            // ]))
            // ->add('dateDisponibilite', DateType::class, $this->getConfiguration('', '', [
            //     'attr' => [
            //         'class' => 'col-md-5 mt-2',
            //     ],
            //     'label' => false,
            //     'widget' => 'single_text',
            //     'required' => false
            // ]))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'mt-4 rounded-0 ',
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Entrez à nouveau le mot de passe',
                        'class' => 'mt-4 rounded-0 ',

                    ]
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                    'min' => 8,
                    'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les termes et conditions et j'accepte la politique de confidentialité",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
