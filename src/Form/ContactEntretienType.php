<?php

namespace App\Form;

use App\Entity\ContactEntretien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class ContactEntretienType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEntretien', DateType::class, $this->getConfiguration('Journ de \'entretien', '', [
                'widget' => 'single_text',

            ]))
            ->add('heureEntretien', TextType::class, $this->getConfiguration('Heure de l\'entretien', '12:00', [
//                'widget' => 'choice',

//                'input' => 'datetime'
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactEntretien::class,
        ]);
    }
}
