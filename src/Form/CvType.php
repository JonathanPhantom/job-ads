<?php

namespace App\Form;

use App\Entity\AnneeExperience;
use App\Entity\Cv;
use App\Entity\Statut;
use App\Entity\DomaineEtude;
use App\Entity\NiveauDePoste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Security;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CvType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreCv', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                    'placeholder' => 'Titre du CV ',
                    'autofocus' => 'autofocus'

                ]
            ])
            ->add("photoProfilFile", FileType::class, [
                'label_attr' => [
                    'class' => 'col-form-label  text-dark  mt-1'
                ],

                'required'=>false
            ])
            ->add('SecteurEtudeSouhaite', EnumType::class, [
                'enum_class' => DomaineEtude::class,
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-11 ml-5',
                ],
                'placeholder' => 'Sélectionnez...'

            ])
            ->add('statut', EnumType::class, [
                'enum_class' => Statut::class,
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-11 ml-5',
                ],
                'placeholder' => 'Sélectionnez...',

            ])
            ->add('niveauPoste', EnumType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ],
                'enum_class' => NiveauDePoste::class,
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                ],
                'placeholder' => 'Sélectionnez...'

            ])
            ->add('disponibilite', ChoiceType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark'
                ],
                'choices' => [
                    'Je ne suis pas encore disponible' => false,
                    'Je suis disponible' => true
                ],
                'attr' => [
                    'class' => 'col-md-11 ml-5',
                    'onChange' => "displayDisponibility('cv_disponibilite')"
                ],
                'placeholder' => 'Sélectionnez...'


            ])
            ->add('dateDisponibilite', DateType::class, [
                'attr' => [
                    'class' => 'col-md-5 mt-2 ',
                ],
                'label' => false,
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('anneeExperience', EnumType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ],
                'enum_class' => AnneeExperience::class,
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                ],
                'placeholder' => 'Sélectionnez...',
                'required' => false

            ])
            ->add('salaire', NumberType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ],
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                    'min' => 0,
                    'data-type' => 'currency',
                    'placeholder' => '100,000 FCFA'
                ],
                'required' => false

            ])
            ->add('experiencesProfessionnelles', CollectionType::class, [
                'entry_type' => ExperiencesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                ],
            ])
            ->add('formations', CollectionType::class, [
                'entry_type' => DiplomeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false
            ])
            ->add('competences', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                ],
                'entry_options' => [
                    'attr' => [
                        'placeholder' => 'Saisissez une compétence'

                    ]
                ]
            ])
            ->add('langues', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'attr' => [
                    'class' => 'col-md-11 mt-1 ml-5',
                ],
                'entry_options' => [
                    'attr' => [
                        'placeholder' => 'Saisissez une langue'

                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cv::class,
        ]);
    }
}
