<?php


namespace App\MesEnumType;


use App\Entity\TypeAbonnement;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class TypeAbonnementType extends AbstractEnumType
{

    const NAME = 'typeAbonnement';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return TypeAbonnement::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}