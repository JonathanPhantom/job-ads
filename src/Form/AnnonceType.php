<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\DomaineEtude;
use App\Entity\TypeContrat;
use App\Entity\NiveauFormation;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends FormConfig
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreAnnonce', TextType::class, $this->getConfiguration('Titre de l\'annonce', 'Saisissez un titre pour votre annonce',[
                'attr'=>[
                    'class'=>'rounded-0 mt-3 ',
                    'placeholder'=>"Saisissez un titre pour votre annonce"
                ]
            ]))
            ->add('anneeExperience', IntegerType::class, $this->getConfiguration('Nombre d\'année d\'expérience', '', [
                'attr' => [
                    'min' => 0,
                    'max' => 80,
                    'placeholder' => 'Nombre d\'années d\'expérience minimum pour ce poste',
                    'class'=>'rounded-0  mt-3'
                ],
                'required'=>false
            ]))
            ->add('description', TextareaType::class, $this->getConfiguration('Description de l\'annonce', '', [
                'attr' => [
                    'placeholder' => 'Saisissez tous les détails de votre annonce ',
                    'rows' => '10',
                    'class'=>'rounded-0 mt-3 textarea',
                ],
                'required'=>false,
            ]))
            // ->add('categories', EntityType::class, $this->getConfiguration('Catégorie(s) de l\'annonce', '', [
            //     'attr'=>[
            //         'class'=>'rounded-0 mt-3'
            //     ],
            //     'class' => Categorie::class,
            //     'choice_label' => 'nomCategorie',
            //     'multiple' => true,
            //     'required'=>false
            // ]))
            ->add('domaineEtudes', EnumType::class, $this->getConfiguration('Domaine d\'Etude', '', [
                'attr'=>[
                    'class'=>'rounded-0 mt-3'
                ],
                'enum_class' => DomaineEtude::class,
                'multiple'=>true
            ]))
            ->add('posteAPourvoir', TextType::class, $this->getConfiguration('Poste disponible', '',[
                'attr'=>[
                    'class'=>'rounded-0 mt-3'
                ],
                'required'=>false,
            ]))
            ->add('nombrePoste', IntegerType::class, $this->getConfiguration('Nombre de Poste disponible', '', [
                'attr' => [
                    'min' => '0',
                    'max' => '50',
                    'class'=>'rounded-0 mt-3'

                ],
                'required'=>false
            ]))
            ->add('niveauFormation', EnumType::class, $this->getConfiguration('Niveau de formation', '', [
                'attr'=>[
                    'class'=>'rounded-0 mt-3'
                ],
                'enum_class' => NiveauFormation::class
            ]))
            ->add('typeContrat', EnumType::class, $this->getConfiguration('Type de Contrat', '', [
                'attr'=>[
                    'class'=>'rounded-0 mt-3'
                ],
                'enum_class' => TypeContrat::class
            ]))
            ->add('salaire', IntegerType::class, $this->getConfiguration('Salaire', '',[
                'attr'=>[
                    'class'=>'rounded-0 mt-3',
                    'min'=>0
                ]
                ,'required'=>false
            ]))
            ->add('dateLimite', DateType::class, $this->getConfiguration('Date d\'expiration de l\'annonce', 'aa-mm-dd', [
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'text-center col-md-5 rounded-0 mt-3'
                ]
            ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
