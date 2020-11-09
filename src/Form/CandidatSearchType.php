<?php

namespace App\Form;

use App\Entity\CandidatSearch;
use App\Entity\DomaineEtude;
use App\Entity\Localites;
use App\Entity\NiveauFormation;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatSearchType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration('Nom du candidat', 'Nom du candidat', [
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'class' => 'ml-0 mr-0 mt-3',
                    'placeholder' => 'Entrez Nom',
                    'style' => 'border-radius: 0'
                ]
            ]))
            ->add('localite', EnumType::class, $this->getConfiguration('Adresse', 'Adresse', [
                'enum_class' => Localites::class,
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'class' => 'ml-0 mr-0',
                    'placeholder' => 'Adresse',
                    'style' => 'border-radius: 0',
                    'selected' => false
                ]
            ]))
            ->add('domaineEtude', EnumType::class, $this->getConfiguration('Domaine d\'étude', 'Domaine d\'étude', [
                'enum_class' => DomaineEtude::class,
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'class' => 'ml-0 mr-0 mt-3',
                    'placeholder' => 'Domaine d\'étude',
                    'style' => 'border-radius: 0',
                    'autofocus' => false,
                    'selected' => false
                ]
            ]))
            ->add('niveauFormation', EnumType::class, $this->getConfiguration('Niveau de formation', 'niveau de formation', [
                'enum_class' => NiveauFormation::class,
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'placeholder' => 'Niveau de formation',
                    'style' => 'border-radius: 0',
                    'selected' => false
                ],
                'placeholder' => "Rechercher par le niveau de formation"
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CandidatSearch::class,
        ]);
    }
}
