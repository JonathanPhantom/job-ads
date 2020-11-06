<?php


namespace App\MesEnumType;


use App\Entity\Statut;
use Elao\Enum\Bridge\Doctrine\DBAL\Types\AbstractEnumType;

final class StatutType extends AbstractEnumType
{

    const NAME = "statut";

    /**
     * @inheritDoc
     */
    protected function getEnumClass(): string
    {
        return Statut::class;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}