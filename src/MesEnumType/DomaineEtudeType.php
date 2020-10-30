<?php


namespace App\MesEnumType;


use App\Entity\DomaineEtude;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class DomaineEtudeType extends AbstractEnumType
{
    //Permet de créer une Type DomaineEtude à utiliser

    const NAME = "domaineEtude";

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        //implementation de la fonction
        return DomaineEtude::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}