<?php

namespace App\Form;

use App\Entity\DomaineEtude;
use App\Entity\Localites;
use App\Entity\NiveauFormation;
use App\Entity\AnnonceSearch;
use App\Entity\TypeContrat;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceSearchType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //TODO: mise en place de form de search
        $builder
            ->add('titreAnnonce', TextType::class, $this->getConfiguration('Mots clés, Titre de l\'annonce', '', [
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'class' => 'ml-0 mr-0 mt-3 rounded-0',
                    'placeholder' => 'Mots clés, Titre de l\'annonce',
                ]
            ]))
            ->add('domaineEtude', EnumType::class, $this->getConfiguration('', '', [
                'enum_class' => DomaineEtude::class,
                'label' => false,
                'required' => false,
                'multiple' => false,
                'placeholder' => "Rechercher par le domaine d'étude"

            ]))

            ->add('niveauFormation', EnumType::class, $this->getConfiguration('Niveau de formation', 'niveau de formation', [
                'enum_class' => NiveauFormation::class,
                'required' => false,
                'label' => false,
                'attr' => [
                    'label' => false,
                    'selected' => false,
                    'class'=>'d-none rounded-0'
                ],
                    'placeholder' => 'Niveau de formation',
            ]))
            ->add('localites', EnumType::class, $this->getConfiguration('', '', [
                'enum_class' => Localites::class,
                'label' => false,
                'required' => false,
                'multiple' => false,
                'placeholder' => "Rechercher par Ville ou Région",
                'attr' => [
                    'label' => false,
                    'selected' => false,
                    'class'=>'d-none rounded-0'
                ]

            ]))
            ->add('typeContrat', EnumType::class, $this->getConfiguration('', '', [
                'enum_class' => TypeContrat::class,
                'label' => false,
                'required' => false,
                'multiple' => false,
                'placeholder' => "Le type de contrat de l'annonce",
                'attr' => [
                    'label' => false,
                    'selected' => false,
                    'class'=>'d-none rounded-0'
                ]

            ]))

        ;
    }

    //pour que les recherche ne se postent pas on utilisent les méthodes en get
    //on desactive la protection csrf car il n'ya pas besoin de token pour faire les recherches
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnnonceSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
