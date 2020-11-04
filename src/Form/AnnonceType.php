<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\DomaineEtude;
use App\Entity\NiveauFormation;
use App\Entity\TypeContrat;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\MesEnumType;

class AnnonceType extends FormConfig
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreAnnonce', TextType::class, $this->getConfiguration('Titre de l\'annonce', 'Entrez le titre de l\'annonce'))
            ->add('anneeExperience', IntegerType::class, $this->getConfiguration('Nombre d\'année d\'expérience', ''))
            ->add('description', TextareaType::class, $this->getConfiguration('Description de l\'annonce', 'Décrivez votre annonce'))
            ->add('posteAPourvoir', TextType::class, $this->getConfiguration('Poste Disponible', ''))
            ->add('salaire', IntegerType::class, $this->getConfiguration('Salaire', ''))
            ->add('nombrePoste', IntegerType::class, $this->getConfiguration('Nombre de Poste disponible', ''))
            ->add('categories', EntityType::class, $this->getConfiguration('Catégorie(s) de l\'annonce', '', [
                'class' => Categorie::class,
                'choice_label' => 'nomCategorie',
                'multiple' => true
            ]))
            ->add('domaineEtude', EnumType::class, $this->getConfiguration('Domaine d\'Etude', '', [
                'enum_class' => DomaineEtude::class,

            ]))
            ->add('niveauFormation', EnumType::class, $this->getConfiguration('Niveau de formation', '', [
                'enum_class' => NiveauFormation::class
            ]))
            ->add('typeContrat', EnumType::class, $this->getConfiguration('Type de Contrat', '', [
                'enum_class' => TypeContrat::class
            ]))
            ->add('dateLimite', DateType::class, $this->getConfiguration('Date d\'expiration de l\'annonce', 'aa-mm-dd',[
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
