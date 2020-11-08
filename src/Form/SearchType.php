<?php

namespace App\Form;

use App\Entity\DomaineEtude;
use App\Entity\Localites;
use App\Entity\NiveauFormation;
use App\Entity\Search;
use App\Entity\TypeContrat;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //TODO: mise en place de form de search
        $builder
            ->add('localites', EnumType::class, $this->getConfiguration('', '', [
                'enum_class' => Localites::class,
                'label' => false,
                'required' => false,
                'multiple' => false,

                'placeholder' => "Ville ou Région"

            ]))
            ->add('domaineEtude', EnumType::class, $this->getConfiguration('', '', [
                'enum_class' => DomaineEtude::class,
                'label' => false,
                'required' => false,
                'multiple' => false,
                'placeholder' => "Domaine d'étude"

            ]));
    }

    //pour que les recherche ne se postent pas on utilisent les méthodes en get
    //on desactive la protection csrf car il n'ya pas besoin de token pour faire les recherches
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
