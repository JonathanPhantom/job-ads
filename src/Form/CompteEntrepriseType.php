<?php

namespace App\Form;

use App\Entity\DomaineActivite;
use App\Entity\Entreprise;
use App\Entity\Localites;
use App\MesEnumType\LocalitesType;
use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompteEntrepriseType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEntreprise',TextType::class,$this->getConfiguration('','Saisissez le nom de votre entreprise',[
                'label'=>false,
            ]))
            ->add('secteurActivite',EnumType::class,[
                'label'=>false,
                'enum_class'=>DomaineActivite::class,
                'placeholder'=>'Secteur d\'activité de l\'entreprise'
            ])
            ->add('adresse',TextType::class,$this->getConfiguration('','Adresse de l\'entreprise',[
                'label'=>false
            ]))
            ->add('siteWeb',UrlType::class,$this->getConfiguration('','Lien vers votre site web',[
                'required'=>false
            ]))
            ->add('localite',EnumType::class,$this->getConfiguration('','',[
                'enum_class'=>Localites::class
            ]))
            ->add('telephone',TelType::class,$this->getConfiguration('','Téléphone ou Numéro service clientelle'))
            ->add('photoProfilFile',FileType::class,[
                'label'=>'Logo de l\'entreprise',
                'required'=>false
            ])
            ->add('nomContact',TextType::class,$this->getConfiguration('','Nom du contatct',[
                'label'=>false
            ]))
            ->add('emailContact',TextType::class,$this->getConfiguration('','Email  du contatct',[
                'label'=>false
            ]))
            ->add('numeroContact',TextType::class,$this->getConfiguration('','Téléphone du contatct',[
                'label'=>false
            ]))
            ->add('email',EmailType::class,$this->getConfiguration('','Votre adresse email '))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'mt-4'
                    ]
                ],
                'second_options' => ['label' => false,
                    'attr' => [
                        'placeholder' => 'Entrez à nouveau le mot de passe']
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    /*new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),*/
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
