<?php

namespace App\Form;

use App\Entity\Diplome;
use App\Entity\DomaineEtude;
use App\Entity\NiveauFormation;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiplomeType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domaine', EnumType::class, $this->getConfiguration('Domaine d\'étude', '', [
                'enum_class' => DomaineEtude::class
            ]))
            ->add('niveau', EnumType::class, $this->getConfiguration('Niveau', '', [
                'enum_class' => NiveauFormation::class,
            ]))
            ->add('dateObtention', IntegerType::class, $this->getConfiguration('Date d\'obtention', ''))
            ->add('justificatifFile', FileType::class, $this->getConfiguration('Justificatif', ''))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diplome::class,
        ]);
    }
}
