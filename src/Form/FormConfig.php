<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;

class FormConfig extends AbstractType
{
    //permet de gérer les options des formulaires
    public function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}