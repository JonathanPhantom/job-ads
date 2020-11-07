<?php

namespace App\Form;

use App\Entity\DomaineActivite;
use Symfony\Component\Form\AbstractType;
use App\Entity\ExperienceProfessionnelle;
use App\Entity\Localites;
use App\Entity\NiveauDePoste;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExperiencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titrePoste', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ]
            ])
            ->add('dateDebut', DateType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ],
                'widget' => 'single_text'
            ])
            ->add('dateFin', DateType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ],
                'widget' => 'single_text'
            ])
            ->add('nomEntreprise', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ]
            ])
            ->add('secteurActivite', EnumType::class, [
                'enum_class' => DomaineActivite::class,
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ],
                'placeholder' => 'Sélectionnez...'
            ])
            ->add('descriptionExperience', TextareaType::class, [
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ], 'attr' => [
                    'class' => 'col-md-6 ml-5',
                ]
            ])
            ->add('niveauPoste', EnumType::class, [
                'enum_class' => NiveauDePoste::class,
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ],
                'attr' => [
                    'class' => 'col-md-6 ml-5',
                ],
                'placeholder' => 'Sélectionnez...'
            ])
            ->add('localite',EnumType::class,[
                'enum_class' => Localites::class,
                'label_attr' => [
                    'class' => 'col-sm-3 col-form-label  text-dark  mt-1'
                ],
                'attr' => [
                    'class' => 'col-md-6 ml-5',
                ],
                'placeholder' => 'Sélectionnez...'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExperienceProfessionnelle::class,
        ]);
    }
}
