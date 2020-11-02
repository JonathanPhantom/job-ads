<?php


namespace App\MesEnumType;


use App\Entity\TypeContrat;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class TypeContratType extends AbstractEnumType
{

    const NAME = 'typeContrat';

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return TypeContrat::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}