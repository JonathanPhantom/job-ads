<?php

namespace App\Form;

use App\Entity\DomaineEtude;
use App\Entity\Profil;
use App\Entity\TypeContrat;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfilType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competences', TextType::class, $this->getConfiguration('Vos Compétences', 'compétence1, compétence2, ...'))
            ->add('anneeExperience', IntegerType::class, $this->getConfiguration('Année(s) d\'expérience', ''))
            ->add('cvFile', FileType::class, $this->getConfiguration('CV', ''))
            ->add('domaineEtudeProfil', EnumType::class, $this->getConfiguration('Domaine d\'étude', '', [
                'enum_class' => DomaineEtude::class
            ]))
            ->add('typeContrat', EnumType::class, $this->getConfiguration('Type de Contrat', '', [
                'enum_class' => TypeContrat::class,
                //'multiple' => true
            ]))
            ->add('isPrincipal', ChoiceType::class, $this->getConfiguration('Cet Profil est t\'il votre profil principal', '',[
                'choices' => [
                    'oui' => true,
                    'non' => false
                ],
                'expanded' => true
            ]))
            ->add('diplomes', CollectionType::class, [
                'entry_type' => DiplomeType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
