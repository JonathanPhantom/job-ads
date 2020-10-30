<?php


namespace App\MesEnumType;


use App\Entity\NiveauFormation;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class NiveauFormationType extends AbstractEnumType
{

    const NAME = 'niveauFormation';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return NiveauFormation::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}