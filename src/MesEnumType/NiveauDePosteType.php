<?php


namespace App\MesEnumType;




use App\Entity\NiveauDePoste;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class NiveauDePosteType extends AbstractEnumType
{

    const NAME = "niveauDePoste";

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return NiveauDePoste::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}